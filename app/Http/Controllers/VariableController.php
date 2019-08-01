<?php

namespace App\Http\Controllers;

use App\Variable;
use Illuminate\Http\Request;

class VariableController extends Controller
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
        // check if one already exists
        if(!count(Variable::where(['template_id'=>$request->input('template_id'), 'variable'=>$request->input('variable')])->get())) {
            $request->validate([
                'template_id' => ['required'],
                'name' => ['required', 'string', 'max:255'],
                'variable' => ['required', 'string', 'max:255', 'regex:/^\S*$/u'],
            ]);

            $newVariable = new Variable([
                'name' => $request->input('name'),
                'variable' => $request->input('variable'),
                'template_id' => $request->input('template_id')
            ]);
            $newVariable->save();
        }

        return response()->json($newVariable);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    public function show(Variable $variable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    public function edit(Variable $variable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variable $variable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variable $variable)
    {
        //
    }
}
