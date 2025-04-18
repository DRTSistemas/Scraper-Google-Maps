<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

class ProfileAdminController extends BaseController

{

    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */

    public function edit()

    {

        if (!$this->checkAdmin()) {

            return redirect()->route('login');

        }


        return view('admin.profile.edit');

    }


    /**
     * Update the profile
     *
     * @param \App\Http\Requests\ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(ProfileRequest $request)

    {

        if (!$this->checkAdmin()) {

            return redirect()->route('login');

        }


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

        if (!$this->checkAdmin()) {

            return redirect()->route('login');

        }

        $password = Hash::make($request->get('password'));

        DB::connection('suporte')->table('users')
            ->where('username', auth()->user()->username)
            ->update(['password' => $password]);

        auth()->user()->update(['password' => $password]);


        return back()->withPasswordStatus(__('Password successfully updated.'));

    }

}

