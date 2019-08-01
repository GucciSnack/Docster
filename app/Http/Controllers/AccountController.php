<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myAccount(){
        return view('app.account.manage');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storeAccountChanges(Request $request){
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user())],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
        ]);

        $user = auth()->user();

        // store changes
        $user->email = $request->input('email');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->update();

        // check if storing a new password
        if(!empty($request->input('old-password')) && !empty($request->input('password'))){
            if(Hash::check($request->input('old-password'), $user->password)){
                // verify passwords match
                $request->validate([
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                ]);

                // store password changes
                $user->password = Hash::make($request->input('password'));
                $user->update();
            } else {
                $validator = Validator::make((array)$request,[
                    ['old-password'  => 'required'],
                    ['old-password.required' => 'Password is incorrect.']
                ]);
                $validator->getMessageBag()->add('old-password', 'Password is incorrect.');
                return Redirect::route('account.manage')->withErrors($validator);
            }
        }

        return $this->myAccount();
    }
}
