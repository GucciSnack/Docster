<?php

namespace App\Http\Controllers;

use App\Template;
use App\Variable;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.template.templates', [
            'edit'          => false,
            'templates'     => Template::orderBy('updated_at', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate input
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'content'   => ['required'],
        ]);

        // if we're updating, pass to the update
        if ($request->input('template_id'))
        {
            $this->update($request, Template::find($request->input('template_id')));
            return redirect()->route('template.index');
        }

        // create template
        $template = new Template([
            'name'      => $request->input('name'),
            'content'   => $request->input('content'),
        ]);

        $template->save();

        // create variables
        $variables = $request->input('variables');
        $signatures = ($request->input('signatures') != null) ? $request->input('signatures') : [];

        if ($variables !== null) {
            $template->saveVariables($variables, $signatures);
        }

        return redirect()->route('template.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        return response()->json([
            'content'       => $template->content,
            'variables'     => $template->variables
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        return view('app.template.edit', [
            'template'      => $template
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        // validate input
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'content'   => ['required'],
        ]);

        $template->name = $request->input('name');
        $template->content = $request->input('content');
        $template->update();

        // store new records
        $variables = $request->input('variables');
        $signatures = ($request->input('signatures') != null) ? $request->input('signatures') : [];
        $template->saveVariables($variables, $signatures);

        return redirect()->route('template.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        if ($template != null) {
            $template->variables()->delete();
            $template->delete();
            return response()->json(['destroyed'=>1]);
        }
        return response()->json(['destroyed'=>0]);
    }

    /**
     * @param Template $template
     * @return \Illuminate\Http\JsonResponse
     */
    public function variables(Template $template)
    {
        $variables = $template->variables;

        return response()->json($variables);
    }
}
