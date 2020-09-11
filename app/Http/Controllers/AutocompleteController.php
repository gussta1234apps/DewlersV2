<?php

namespace App\Http\Controllers;

use App\ctl_users;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function autocomplete( Request $request){

        $search = $request->get('term');

        $result=ctl_users::where('username','LIKE','%'.$search.'%')->get();

        return json_encode($result);

//        create confirm
//        create numel


    }
}
