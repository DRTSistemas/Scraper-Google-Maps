<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\User;

class TreeController extends BaseController
{
    
    public function index(Request $request)
    {
        $config = $this->config();

        $one_level = User::where([
        	['indication_id', auth()->user()->id]
        ])->get();

        $two_level = []; $tres_level = []; $four_level = [];

        foreach($one_level as $value) {
        	$query = User::where([
	        	['indication_id', $value->id]
	        ])->get();

        	$two_level[] = $query;

        	foreach($query as $value1) {
        		$query1 = User::where([
		        	['indication_id', $value1->id]
		        ])->get();

		        $tres_level[] = $query1;

		        foreach($query1 as $value2) {
	        		$query2 = User::where([
			        	['indication_id', $value2->id]
			        ])->get();

			        $four_level[] = $query2;
	        	}
        	}
        }

        //dd($one_level, $two_level, $tres_level, $four_level);

        /*
        foreach($one_level as $index => $value) {
        	echo $value->username . '<br>';

        	foreach($two_level[$index] as $value1) {
        		echo '-- '. (!empty($value1->username) ? $value1->username : 'None') . '<br>';
        	}
        }

        exit();
        */

        return view('tree.index', [
            'config'  => $config,
            'one_level' => $one_level,
            'two_level' => $two_level,
            'tres_level' => $tres_level,
            'four_level' => $four_level,
        ]);
    }

}
