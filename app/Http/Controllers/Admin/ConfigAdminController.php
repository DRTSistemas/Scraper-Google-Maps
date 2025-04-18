<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;



use App\Config;



class ConfigAdminController extends BaseController

{

    public function index()

    {

        if(!$this->checkAdmin()){

            return redirect()->route('login');

        }



        return view('admin.config.index', ['config' => $this->config()]);

    }



    public function update(Request $request, $id)

    {

        if(!$this->checkAdmin()){

            return redirect()->route('login');

        }



        $data = $request->validate([

            "api_key_serper" => "required",

            "whatsapp_support" => "required",

        ]);


        foreach ($data as $key => $value) {

            $config = new Config;

            $update = $config->where('name', $key)->update(['value' => $value]);   

        }

       

        return back()->withStatus('Success');

    }

}

