<?php

namespace App\Http\Controllers;

use App\duelstatuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DONController extends Controller
{
    public function save_don(Request $request)    {
        $user=Auth::user();
//        $challenger=DB::table('')
        $new_description=$request->post('description');


        $id_duel=$request->post('duel');

        $user_challenger=$user->id;
        $new_pot= DB::table('duels')->where('id',$id_duel)->first();
        $pot=($new_pot->pot) *2;

        //if new_pot has witness  duel state == 10
        if($new_pot->ctl_user_id_witness != null){

            DB::table('duels')->where('id', $id_duel)->update(['pot'=>$pot,'don'=>2,'duelstate'=>10,'Description'=>$new_description]);

        }else{

            DB::table('duels')->where('id', $id_duel)->update(['pot'=>$pot,'don'=>2,'duelstate'=>7,'Description'=>$new_description]);

        }

        return redirect('/dashboard');


    }


    public function acept_don($duel_id){

        DB::table('duels')->where('id', $duel_id)->update(['duelstate'=> 5]);
        return view('UserMenu.index');
    }
}
