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

        //dd($this->config());

        // $config = $this->config();
        // $apiKeys = explode("\r\n", $config['api_key_serper']);
        // $apiKeys = array_map('trim', $apiKeys);

        // unset($apiKeys[3]);
        // $apiKeys = array_values($apiKeys);

        // $apiKeysImplode = implode("\r\n", $apiKeys);

        // dd($config['api_key_serper'], $apiKeys, $apiKeysImplode);

        if(!$this->checkAdmin()){

            return redirect()->route('login');

        }



        return view('admin.config.index', ['config' => $this->config()]);

    }



    public function update(Request $request, $id)

    {

        //dd($request->all(), $id);
        //dd(str_replace(' ', '', $request->api_key_serper));

        if(!$this->checkAdmin()){

            return redirect()->route('login');

        }

        $data = $request->validate([

            "api_key_serper" => "required",

            "whatsapp_support" => "required",

        ]);

        $data["api_key_serper"] = collect(explode("\n", $data["api_key_serper"]))
        ->filter(fn($linha) => \Str::of($linha)->trim()->isNotEmpty())
        ->implode("\n");

        foreach ($data as $key => $value) {

            $config = new Config;

            $update = $config->where('name', $key)->update(['value' => $value]);   

        }

       

        return back()->withStatus('Success');

    }

}

