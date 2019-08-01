<?php

namespace App\Http\Controllers;

use App\Document;
use App\Template;
use PDF;
use Illuminate\Http\Request;

class DocumentController extends Controller
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
    public function create(Request $request)
    {
        return view('app.document.create', [
            'templates'         => Template::all(),
            'template_id'       => $request->input('template_id') ?? 0,
            'content'           => ($request->input('template_id') != null) ? Template::find($request->input('template_id'))->content : ''
        ]);
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
            'name'      => ['required', 'string', 'max:255'],
            'content'   => ['required']
        ]);

        //check if already exists
        if($request->input('document_id'))
        {
            $this->update($request, Document::find($request->input('document_id')));
            return redirect()->route('document.show', ['document'=>$request->input('document_id')]);
        }

        $newDocument = new Document([
            'name'              => $request->input('name'),
            'content'           => $request->input('content')
        ]);
        $newDocument->setVariables($request->input('variables'), $request->input('signature'));

        $newDocument->save();

        return redirect()->route('document.show', ['document'=>$newDocument->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return view('app.document.view',[
            'title'     => $document->name,
            'document'  => $document
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return view('app.document.create', [
            'edit'              => true,
            'templates'         => Template::all(),
            'document'          => $document
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        // validate input
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'content'   => ['required'],
        ]);

        $document->name = $request->input('name');
        $document->content = $request->input('content');
        $document->setVariables($request->input('variables'), $request->input('signature'));

        $document->update();

        return redirect()->route('document.show', ['document'=>$request->input('document_id')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        if($document != null){
            $document->viewLinks()->delete();
            $document->signers()->delete();
            $document->delete();
            return response()->json(['destroyed'=>1]);
        }
        return response()->json(['destroyed'=>0]);
    }

    /**
     * @param Request $request
     * @return array|string|null
     */
    public function preview(Request $request){
        $content = $request->input('content');
        $variableValues = $request->input('variable_values');

        $document = new Document([
            'content'           => $content,
            'variable_values'   => json_encode($variableValues)
        ]);

        return $document->processedDocument();
    }

    public function download(Document $document)
    {
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
