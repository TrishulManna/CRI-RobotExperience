<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class RequestformController extends Controller
{


    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/requestform';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'phonenumber' => 'required|min:8',
            'email' => 'required|email|max:255|unique:users',
            'company' => 'required|max:255',
            'address' => 'required|max:255',
            'postalcode' => 'required|max:255',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(Request $request)
    {
        $data = Input::all();

        \App\Request::create([
            'name' => $data['name'],
            'phonenumber' => $data['phonenumber'],
            'email' => $data['email'],
            'company' => $data['company'],
            'address' => $data['address'],
            'postalcode' => $data['postalcode'],

        ]);

        return redirect('/home');

}

    public function index()
    {

            $request= DB::table('requests')->get();

            return view('requestoverview', compact('request'));
    }


}
