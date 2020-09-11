<?php

namespace App\Http\Controllers;

use App\ctl_users;
use App\double_or_nothing;
use App\duels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

class IndexController extends Controller
{
    //Shows App Index
    public function index()
    {
        $id = Auth::user();

        $actualamount = DB::table('internalaccounts')->where('id','=',$id->id)->first();

        return view('UserMenu.index')->with('actualamount',$actualamount->balance);
    }



    public function index_tables(){

                $duels_to_Delete=duels::where('duelstate','=',4)->orWhere('duelstate','=',9)->get();

        foreach ($duels_to_Delete as $du){

            $stop_date = new DateTime(); //fecha de hoy
//            echo "Hoy es ".$stop_date->format('Y-m-d'); //formato a fecha de hoy
//            echo " <br> ";

            $evaluate_date = new DateTime($du->startDate); //fecha de hoy

//            echo "fecha a evaluar ".$evaluate_date->format('Y-m-d'); //fecha evaluada modificada dos dias


            $nextdat=$evaluate_date->modify('+2 day');
//            echo " Fecha modificada ". $nextdat->format('Y-m-d'); //fecha evaluada modificada dos dias

            if($nextdat->format('Y-m-d') <= $stop_date->format('Y-m-d')){

                $to_delete_don= double_or_nothing::where('duel_id',$du->id)->get();

                if ($to_delete_don){

                    foreach ($to_delete_don as $del){

                        $del->delete();
                    }

                }

                $du->delete();
            }



        }

        $id_auth=Auth::user();
        $due2=duels::with('ctlUser0','ctlUser3', 'duelstatus')->where([['ctl_user_id_challenger','=',$id_auth->id],['duelstate','!=',6],['duelstate','!=',8]])->orWhere([['ctl_user_id_challenged','=',$id_auth->id],['duelstate','!=',6],['duelstate','!=',8]])->orderBy('id', 'desc')->get(); //->orWhere([['ctl_user_id_witness','=',$id_auth->id],['duelstate','!=',6]])



        //detalles para el front
//-------------------------------------------------------------*------------------------------------------------------------*------------------------------------
        //Currents DEWLS
        //if duelstatus != finish codigo 4  y ctl_user_witness != usuariologueado
//-------------------------------------------------------------*------------------------------------------------------------*------------------------------------
        //Historial

        // Win
        //if duelstatus == finish codigo 6  y  ctl_user_winner == usuariologueado
        $record_winner=duels::with('ctlUser0','ctlUser3', 'duelstatus')->where( [['ctl_user_id_winner','=',$id_auth->id],['duelstate','=',6]])->orWhere([['ctl_user_id_winner','=',$id_auth->id],['duelstate','=',8]])->orderBy('id', 'desc')->get();

        //Lost
        //if duelstatus == finish codigo 6  y  ctl_user_winner != usuariologueado y ctl_user_witness != usuario logeado
        $record_loser=duels::with('ctlUser0','ctlUser3', 'duelstatus')->where([['ctl_user_id_loser','=',$id_auth->id],['duelstate','=',6]])->orWhere([['ctl_user_id_loser','=',$id_auth->id],['duelstate','=',6]])->orWhere([['ctl_user_id_loser','=',$id_auth->id],['duelstate','=',8]])->orWhere([['ctl_user_id_loser','=',$id_auth->id],['duelstate','=',8]])->orderBy('id', 'desc')->get();


        //Witness
        //if duelstatus == finish codigo 6  y ctl_user_witness == usuariologueado
        $record_witness=duels::with('ctlUser0','ctlUser3', 'duelstatus')->where([['ctl_user_id_witness','=',$id_auth->id],['duelstate','=',6]])->orWhere([['ctl_user_id_witness','=',$id_auth->id],['duelstate','=',8]])->orderBy('id', 'desc')->get();


//-------------------------------------------------------------*------------------------------------------------------------*------------------------------------

        //Witness
        //if duelstatus == finish codigo 6  y ctl_user_witness == usuariologueado
        $dash_witness=duels::with('ctlUser0','ctlUser3', 'duelstatus')->where([['ctl_user_id_witness','=',$id_auth->id],['duelstate','!=',6],['duelstate','!=',8]])->orderBy('id', 'desc')->get();

        //WITNESS

        //if duelstatus != finish codigo 4  y ctl_user_witness == usuariologueado

        $me_user=ctl_users::where('id',$id_auth->id)->first();

        $friends=$me_user->getFriends();

        //return view('UserMenu.index')->with('duels',$due2)->with('challengeds',$friends)->with('r_winner', $record_winner)->with('r_loser',$record_loser)->with('r_witness',$record_witness)->with('dash_witness',$dash_witness);
        return view('UserMenu.layout')->with('duels',$due2)->with('challengeds',$friends)->with('r_winner', $record_winner)->with('r_loser',$record_loser)->with('r_witness',$record_witness)->with('dash_witness',$dash_witness);

    }

    public function api($id_duel)
    {

        $evalue=duels::where('id',$id_duel)->first();
                switch ($evalue->duelstate){
            case 1:
                $re="1";
                break;
            case 2:
                $re="2";
                break;
            case 3:
                $re="3";
                break;
            case 4:
                $re="4";
                break;
            case 5:
                $re="5";
                break;
            case 6:
                $re="6";
                break;
            case 7:
                $re="7";
                break;
            case 8:
                $re="8";
                break;
            case 9:
                $re="9";
                break;
            case 10:
                $re="10";
                break;
            case 11:
                $re="11";
                break;

        }

        return $re;

    }


}
