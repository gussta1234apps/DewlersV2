<?php

namespace App\Http\Controllers;

use App\ctl_users;
use App\double_or_nothing;
use App\duels;
use App\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
use Exception;
use stdClass;

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

        //- Witness finished dewls        
        $finished_witness_dewls = duels::with('ctlUser0','ctlUser3', 'duelstatus')->where([['ctl_user_id_witness','=',$id_auth->id],['duelstate','=',6]])->orWhere([['ctl_user_id_witness','=',$id_auth->id],['duelstate','=',8]])->orderBy('id', 'desc')->get();
        //-
        $reviews        = 0.00; 
        $reviewsCount   = 0; 
        $hypeRating     = 0.0; 
        $hype           = 0.0;     
        $haveHypeRating = true;
        //- Stars counts
        $starsCount[0]  = 0; 
        $starsCount[1]  = 0; 
        $starsCount[2]  = 0; 
        $starsCount[3]  = 0; 
        $starsCount[4]  = 0;   
        //- Stars percent
        $starsPercent[0]  = 0; 
        $starsPercent[1]  = 0; 
        $starsPercent[2]  = 0; 
        $starsPercent[3]  = 0; 
        $starsPercent[4]  = 0;   
        //-
        foreach($finished_witness_dewls as $dewl){
            try{
                $result     = DB::table('reviews')->where('rol', $dewl->id)->first();
                $reviewsCount++;
                $reviews    += $result->stars;

                //- Star count validations and upper
                if($result->stars==5){ $starsCount[4]++; }
                else if($result->stars==4){ $starsCount[3]++; }
                else if($result->stars==3){ $starsCount[2]++; }
                else if($result->stars==2){ $starsCount[1]++; }
                else if($result->stars==1){ $starsCount[0]++; }
            }catch(Exception $e){ /* nothing */}
        }
        $starsCount[3]+=1;$reviewsCount+=1;

        //- Hype rating avg
        try{
            $hype           = $reviews/$reviewsCount;
            $hypeRating     = ($hype*100)/5;
        }catch(Exception $ex){
            $haveHypeRating = false;
        }

        //- Stars percent calc
        $starsPercent[0] = ($starsCount[0]*100)/$reviewsCount;
        $starsPercent[1] = ($starsCount[1]*100)/$reviewsCount;
        $starsPercent[2] = ($starsCount[2]*100)/$reviewsCount;
        $starsPercent[3] = ($starsCount[3]*100)/$reviewsCount;
        $starsPercent[4] = ($starsCount[4]*100)/$reviewsCount;

        //- WINNER COUNT
        $winnerCount = count($record_winner);


        //WITNESS

        //if duelstatus != finish codigo 4  y ctl_user_witness == usuariologueado

        $me_user=ctl_users::where('id',$id_auth->id)->first();

        $friends=$me_user->getFriends();

        //Friends request
        $ctl_log_user= ctl_users::where('id','=',$id_auth->id)->first();

        $resquet_pending= $ctl_log_user->getFriendRequests();

        if($haveHypeRating){
            return view('UserMenu.layout')->with('duels',$due2)->with('challengeds',$friends)->with('r_winner', $record_winner)->with('r_loser',$record_loser)->with('r_witness',$record_witness)->with('dash_witness',$dash_witness)->with('pending_f_req',$resquet_pending)->with('hypeRating',$hypeRating)->with('noHypeRating',false)->with('winnerCount',$winnerCount)->with('stars',$starsCount)->with('starsPercent',$starsPercent);
        }else{
            return view('UserMenu.layout')->with('duels',$due2)->with('challengeds',$friends)->with('r_winner', $record_winner)->with('r_loser',$record_loser)->with('r_witness',$record_witness)->with('dash_witness',$dash_witness)->with('pending_f_req',$resquet_pending)->with('noHypeRating',true)->with('winnerCount',$winnerCount);
        }
        //return view('UserMenu.index')->with('duels',$due2)->with('challengeds',$friends)->with('r_winner', $record_winner)->with('r_loser',$record_loser)->with('r_witness',$record_witness)->with('dash_witness',$dash_witness);

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

    public function searchFriend(){
        $dewlerName = $_REQUEST['dewlerName'];
        $friends=ctl_users::where('username', 'like', '%' . $dewlerName . '%')->get();
        return $friends;
    }

}
