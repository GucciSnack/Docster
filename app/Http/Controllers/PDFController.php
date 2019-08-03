<?php

namespace App\Http\Controllers;

use App\Document;
use App\Template;
use PDF;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    /**
     * @param Template $template
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function viewTemplate(Template $template){
        $pdf = PDF::loadView('app.pdf.preview_template', [
            'name'=>$template->name,
            'content'=>$template->content
        ]);

        return response($pdf->download("{$template->name}.pdf"), 200)->withHeaders([
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename={$template->name}.pdf",
        ]);
    }

    /**
     * @param Document $document
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function viewDocument(Document $document){
        $pdf = PDF::loadView('app.pdf.document', [
            'name'=>$document->name,
            'content'=>$document->content
        ]);

        return response($pdf->download("{$document->name}.pdf"), 200)->withHeaders([
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename={$document->name}.pdf",
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function previewPDFOutput(Request $request){
        $pdf = PDF::loadView('app.pdf.preview', [
            'name'=>$request->input('name'),
            'content'=>$request->input('content')
        ]);

        return response($pdf->download($request->input('name')), 200)->withHeaders([
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename={$request->input('name')}.pdf",
        ]);
    }
}
