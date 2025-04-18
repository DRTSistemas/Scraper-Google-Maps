<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Auth;

class ProfileController extends BaseController

{

    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */

    public function edit()

    {

        if ($this->checkAdmin()) {

            return redirect()->route('admin.index');

        }


        return view('profile.edit', ['config' => $this->config()]);

    }


    /**
     * Update the profile
     *
     * @param \App\Http\Requests\ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(ProfileRequest $request)

    {


        if (!auth()->user()->update($request->all())) {

            return back()->withError(__('Error'));

        }


        return back()->withStatus(__('Profile successfully updated.'));

    }


    /**
     * Change the password
     *
     * @param \App\Http\Requests\PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function password(PasswordRequest $request)
    {

        $password = Hash::make($request->get('password'));

        DB::connection('suporte')->table('users')
            ->where('username', auth()->user()->username)
            ->update(['password' => $password]);

        auth()->user()->update(['password' => $password]);

        return back()->withPasswordStatus(__('Password successfully updated.'));

    }

}

