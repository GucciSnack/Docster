<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class InstallerController extends Controller
{
    public function installApplication()
    {

        return view('app.installer.form');
    }

    public function setConfigurations(Request $request)
    {
        $logs = [];

        foreach ($request->all() as $key => $value) {
            if ($key !== "_token" && $key !== 'username' && $key !== 'email' && $key !== 'password') {
                $logs[] = "Setting variable {$key} to value {$value}.";
                config([$key => $value]);
                Artisan::call("env:set {$key} '{$value}'");
            }
        }

        // setup database
        Artisan::call("migrate");
        Artisan::call("env:set APP_INSTALLED true");

        // setup user
        $newUser = new User([
            'name' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'first_name' => '',
            'last_name' => '',
        ]);
        $newUser->save();

        return redirect('');
    }
}
