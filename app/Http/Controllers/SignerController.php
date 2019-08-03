<?php

namespace App\Http\Controllers;

use App\Mail\AllPartiesSigned;
use App\ViewLink;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Document;
use Illuminate\Hashing\BcryptHasher;
use App\Signer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => ['required'],
        ]);

        // check if we're updating
        $signerId = $request->input('signer_id');
        if ($signerId != null) {
            $signer = Signer::find($signerId);
            if ($signer != null) {
                return $this->update($request, $signer);
            }
        }

        // get all signing parties through the document variables
        $document = Document::find($request->input('document_id'));
        if ($document === null) {
            return redirect('');
        } else {
            // check if signatures have already been sent
            if (count($document->signers) > 0) {
                foreach ($document->signers as $signer) {
                    $signer->generateAuthCode();
                }
                return redirect()->route('document.show', ['document'=>$document->id]);
            } else {
                // send new signature requests
                $signatureVariables = array_filter((array)$document->getVariables(), function($variable, $i){
                    return (int)$variable->signature_field === 1;
                }, ARRAY_FILTER_USE_BOTH);

                if (count($signatureVariables) > 0) {
                    // create a new signature model for each signer
                    foreach ($signatureVariables as $signer) {
                        // create signature model
                        $newSigner = new Signer([
                            'document_id'           => $document->id,
                            'email'                 => $signer->value
                        ]);
                        $newSigner->generateAuthCode();
                        $newSigner->save();
                    }
                    return redirect()->route('document.show', ['document'=>$document->id]);
                } else {
                    //todo: return with error message indicating there's no signature email field set
                    return redirect()->route('document.show', ['document'=>$document->id]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Signer  $signer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Signer $signer)
    {
        if (isset($request->session()->get('signature_access')[$signer->id]) === true) {
            // get signature fields
            $signatureVariables = array_filter((array)$signer->document->getVariables(), function($variable, $i){
                return (int)$variable->signature_field === 1;
            }, ARRAY_FILTER_USE_BOTH);

            // display contract
            return view('app.signer.contract', [
                'title' => $signer->document->name,
                'signer' => $signer
            ]);
        } else {
            // display code entry form
            return view('app.signer.code_entry', [
                'title' => $signer->document->name,
                'signer' => $signer
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Signer  $signer
     * @return \Illuminate\Http\Response
     */
    public function edit(Signer $signer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Signer  $signer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Signer $signer)
    {
        $request->validate([
            'signature' => ['required'],
        ]);

        $signer->signature_data = json_decode($request->input('signature'));
        $signer->update();

        // check if all parties have signed
        $allPartiesSigned = true;
        foreach ($signer->document->signers as $checkSigner) {
            if (empty($checkSigner->signature_data) === true || $checkSigner->signature_data === null) {
                $allPartiesSigned = false;
            }
        }
        if ($allPartiesSigned === true) {
            foreach ($signer->document->signers as $emailSigner) {
                // create a view link
                $allPartiesSignedViewLink = new ViewLink([
                    'document_id'       => $request->input('document_id'),
                    'fake_path'         => ViewLink::generateToken(25, date('YmdHis')),
                    'password'          => ''
                ]);

                $allPartiesSignedViewLink->save();

                Mail::to($emailSigner->email)->send(new AllPartiesSigned($signer->document->name, $allPartiesSignedViewLink->fake_path));
            }
        }

        // create a view link
        $newViewLink = new ViewLink([
            'document_id'       => $request->input('document_id'),
            'fake_path'         => ViewLink::generateToken(25, date('YmdHis')),
            'password'          => ''
        ]);

        $newViewLink->save();

        return redirect('view-document/' . $newViewLink->fake_path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Signer  $signer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signer $signer)
    {
        //
    }

    /**
     * @param Request $request
     * @param Signer $signer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function requestAccess(Request $request, Signer $signer)
    {
        if (Hash::check($request->input('code'), $signer->authorizationCode->password)) {
            $grantedDocuments = [];
            if ($request->session()->get('signature_access')) {
                $grantedDocuments = $request->session()->get('signature_access');
            }
            $grantedDocuments[$signer->id] = true;
            Session::put('signature_access', $grantedDocuments);
            return redirect()->route('signer.show', [
                'signer' => $signer->id
            ]);
        } else {
            //todo: apply error message when redirecting
            return redirect()->route('signer.show', [
                'signer' => $signer->id
            ]);
        }
    }
}
