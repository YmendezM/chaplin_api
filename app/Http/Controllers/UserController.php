<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
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
        $rules = [
            'user_login'      => 'required',
            'user_pass'     => 'required',
            'user_email'  => 'required|email'
            ];

            try {
                $validator = \Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return [
                        'Datos Vacios',
                        'errors'  => $validator->errors()->all()
                    ];
                }
 
                    User::create([
                                    'user_login' => $request['user_login'],
                                    'user_pass' => bcrypt($request['user_pass']),
                                    'user_nicename' => $request['user_login'],
                                    'user_email' => $request['user_email'],
                                    'user_registered' => date_default_timezone_get(),
                                    'display_name' => $request['user_login'],
                                ]);
                    return ['Usuario Registrado'];

            } catch (Exception $e) {
                    \Log::info('Error creating user: '.$e);
                    return \Response::json(['created' => false], 500);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return ['updated' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return ['deleted' => true];
    }
}
