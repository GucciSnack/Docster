<?php

namespace App\Http\Controllers;

use App\Document;
use App\Template;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('app.dashboard', [
            'templates'         => Template::limit(5)->get(),
            'documents'         => Document::all()
        ]);
    }
}
