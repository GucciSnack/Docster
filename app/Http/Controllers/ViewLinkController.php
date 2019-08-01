<?php

namespace App\Http\Controllers;

use App\Document;
use App\ViewLink;
use PDF;
use Illuminate\Http\Request;

class ViewLinkController extends Controller
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

        //Todo: allow passwords
        $newViewLink = new ViewLink([
            'document_id'       => $request->input('document_id'),
            'fake_path'         => ViewLink::generateToken(25, date('YmdHis')),
            'password'          => ''
        ]);

        $newViewLink->save();

        return redirect()->route('document.show', ['document'=>$newViewLink->document_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $fakepath
     * @return \Illuminate\Http\Response
     */
    public function show(string $fakepath)
    {
        $viewLink = ViewLink::where('fake_path', $fakepath)->first();
        if ($viewLink === null) {
            return redirect('');
        } else {
            $documentId = $viewLink->document_id;
            $document = Document::find($documentId);
            if ($document === null) {
                return redirect('');
            } else {
                $pdf = PDF::loadView('app.pdf.document', [
                    'name'=>$document->name,
                    'content'=>$document->processedDocument()
                ]);

                return response($pdf->download("{$document->name}.pdf"), 200)->withHeaders([
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => "inline; filename='{$document->name}'",
                ]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ViewLink  $viewLink
     * @return \Illuminate\Http\Response
     */
    public function edit(ViewLink $viewLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ViewLink  $viewLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ViewLink $viewLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ViewLink  $viewLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(ViewLink $viewLink)
    {
        $viewLink->delete();
    }
}
