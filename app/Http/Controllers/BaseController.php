<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use Auth;

class BaseController extends Controller
{

    public function config(){

        $config = new Config;
        $data = $config->select('name', 'value')->get();

        $response = [];

        foreach ($data as $key => $value) {

            $response[$value->name] = $value->value;

        }


        return $response;

    }



    public function checkAdmin(){

        if(Auth::user()->level == 1){
            return true;
        }

        if(Auth::user()->level == 3){
            return true;
        }

        return false;

    }

}