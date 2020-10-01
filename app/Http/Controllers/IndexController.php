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
            }catch(Exception $e){ /* nothing */ }
        }

        //- Hype rating avg
        try{
            $hype           = $reviews/$reviewsCount;
            $hypeRating     = ($hype*100)/5;

        }catch(Exception $ex){
            $haveHypeRating = false;
        }

        //- Stars percent calc
        try{
            $starsPercent[0] = ($starsCount[0]*100)/$reviewsCount;
            $starsPercent[1] = ($starsCount[1]*100)/$reviewsCount;
            $starsPercent[2] = ($starsCount[2]*100)/$reviewsCount;
            $starsPercent[3] = ($starsCount[3]*100)/$reviewsCount;
            $starsPercent[4] = ($starsCount[4]*100)/$reviewsCount;
        }catch(Exception $e){

        }

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


    //----------------- CURRENT DEWLS UPDATE FUNCTION -------------------
    public function updateCurrentDewls(){
        $id_auth=Auth::user();
        $duels=duels::with('ctlUser0','ctlUser3', 'duelstatus')->where([['ctl_user_id_challenger','=',$id_auth->id],['duelstate','!=',6],['duelstate','!=',8]])->orWhere([['ctl_user_id_challenged','=',$id_auth->id],['duelstate','!=',6],['duelstate','!=',8]])->orderBy('id', 'desc')->get(); //->orWhere([['ctl_user_id_witness','=',$id_auth->id],['duelstate','!=',6]])

        $html = '<table class="table table-borderless">
            <thead style="color: #08ADD5;">
            <tr>
                <th colspan="4 center">Current Dewls
                <div class="card-style-identifier desktop-identifier">
                    <span style="color:#0d95e8"><em class="fas fa-grip-lines"></em> With witness</span>&nbsp;&nbsp;<span style="color:goldenrod"><em class="fas fa-grip-lines"></em> Without witness</span>
                </div>
                </th>
            </tr>
            <tr class="tr-card-identifier-mobil">
                <td>
                <div class="card-style-identifier">
                    <span style="color:#0d95e8"><em class="fas fa-grip-lines"></em> With witness</span>&nbsp;&nbsp;<span style="color:goldenrod"><em class="fas fa-grip-lines"></em> Without witness</span>
                </div>
                </td>
            </tr>
            </thead>
            <tbody>';

        foreach($duels as $duel){
            $html.='<tr> <td colspan="4">
                    <div  ';
            $imgUrl = '';
            $tooltip='';

            //-
            //- IMG and TOOLTIP validations
            switch($duel->duelstate){
                case 1 :
                    $imgUrl = asset('resources/img/Dewlers iconos_Wai-P2.png'); //{{--  pending oponnet --}}
                    $tooltip = 'data-toggle="tooltip" data-placement="top" title="Pending oponent"';
                    break;
                case 2:
                    $imgUrl = asset('resources/img/Dewlers iconos_Wai-P2-Wi.png'); //}}{{--  pending witness and opponent --}}
                    $tooltip = 'data-toggle="tooltip" data-placement="top" title="Pending witness and oponent"';
                    break;
                case 3:
                     $imgUrl = asset('resources/img/Dewlers iconos_Lo-Wi.png'); //}}  //{{--  pending witness --}}
                     $tooltip = 'data-toggle="tooltip" data-placement="top" title="Pending witness"';
                     break;
                case 4:
                   $imgUrl = asset('resources/img/Dewlers iconos_P1vP2.png'); //}}  //{{--  Dewling --}}
                   $tooltip = 'data-toggle="tooltip" data-placement="top" title="Dewling"';
                   break;
                default:
                    $imgUrl = asset('resources/img/Dewlers iconos_X2.png'); //}}  {{--  Doble o nada --}}
                    $tooltip = 'data-toggle="tooltip" data-placement="top" title="Double or Nothing"';
                break;
            }

            //-
            if($duel->ctl_user_id_witness){ $html.='class="card-table-with-witness"'; }
            else{$html.='class="card-table-without-witness"';}
            //-
            $html.='>
                <div class="short-desc">
                    <div class="row"  data-toggle="collapse" href="#card-current-'.$duel->id.'" role="button" aria-expanded="false" aria-controls="card-current-'.$duel->id.'">
                        <div class="col-2 current-card-column"><h4 class="vs-text-without-witness">VS</h4></div>
                            <div class="col-4 current-card-column">
                                <strong>';
                                if($duel->ctl_user_id_challenger == $id_auth->id){ $html.=$duel->ctlUser1->username; }
                                else{ $html.=$duel->ctlUser0->username; }
            $html.='            </strong>
                                </div>
                                <div class="col-1 current-card-column"><img src="'.$imgUrl.'" width="40" height="40" '.$tooltip.'/></div>
                                <div class="col-4 current-card-column"><strong>'.$duel->pot.' Stacks</strong></div>
                            </div>
                        </div>';

            //If your the challenged and havent accepted the  dewl
            if($duel->ctl_user_id_challenged == $id_auth->id and $duel->duelstate==1)
            {
                $html.='<div class="collapse detail" id="card-current-'.$duel->id.'">
                    <div class="center-mobil txt-blck all-width">
                        <h4 class="card-view-title">Please accept or decline this Dewl</h4>
                        <div class="card-view-info center-mobil">
                            <br>
                            <form action="#" method="post">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="text" value="'.$duel->id.'" name="id" hidden>
                            <div class="row col-6 offset-3">
                                <div class="col">
                                    <button class="first-player-button" id="acept'.$duel->id.'" type="submit" formaction="/acept_duel">Accept</button>
                                </div>
                                <div class="col">
                                    <button class="second-player-button" id="refuse'.$duel->id.'" type="submit" formaction="/delete_duel">Decline</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-1 current-card-column"><em class="fas fa-clock"></em></div>
                    <div class="col-4 current-card-column"><strong>'.$duel->pot.' Stacks</strong></div>
                </div>';
            }
            else if($duel->ctl_user_id_challenged==$id_auth->id && $duel->duelstate==2)
            {
                $html.='<div class="collapse detail" id="card-current-'.$duel->id.'">
                    <div class="center-mobil txt-blck all-width">
                        <h4 class="card-view-title">You have been invited to participate on a Dewl.</h4>
                        <div class="card-view-info center-mobil">
                            <br>
                            <form action="#" method="post">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="text" value="'.$duel->id.'" name="id" hidden>
                            <div class="row col-6 offset-3">
                                <div class="col center-mobil">
                                    <button class="first-player-button" id="acept'.$duel->id.'" type="submit" formaction="/acept_duel">Accept</button>
                                </div>
                                <div class="col center-mobil">
                                    <button class="second-player-button" id="refuse'.$duel->id.'" type="submit" formaction="/delete_duel">Decline</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>';
            }
            else if($duel->ctl_user_id_winner==$id_auth->id && $duel->duelstate==7)
            {
                $html.='<div class="collapse detail" id="card-current-'.$duel->id.'">
                    <div class="center-mobil txt-blck all-width">
                        <h4 class="card-view-title">You have been invited to continue Dewling in a Double or Nothing.</h4>
                        <div class="card-view-info center-mobil">
                            <br>
                            <form action="#" method="post">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="text" value="'.$duel->id.'" name="id" hidden>
                            <div class="row col-8 offset-2">
                                <div class="col center-mobil">
                                    <button class="first-player-button" id="acept'.$duel->id.'" type="submit" formaction="/acept_duel">Accept</button>
                                </div>
                                <div class="col center-mobil">
                                    <button class="second-player-button" id="refuse'.$duel->id.'" type="submit" formaction="/delete_duel">Decline</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>';
            }
            else if($duel->ctl_user_id_winner==$id_auth->id && $duel->duelstate==10)
            {
                $html.='<div class="collapse detail" id="card-current-'.$duel->id.'">
                    <div class="center-mobil txt-blck all-width">
                        <h4 class="card-view-title">You have been invited to continue Dewling in a Double or Nothing.</h4>
                        <br>
                        <form action="#" method="post" class="card-view-info center-mobil">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="text" value="'.$duel->id.'" name="id" hidden>
                            <div class="row col-6 offset-3">
                                <div class="col center-mobil">
                                    <button class="first-player-button" id="acept'.$duel->id.'" type="submit" formaction="/acept_duel">Accept</button>
                                </div>
                                <div class="col center-mobil">
                                    <button class="second-player-button" id="refuse'.$duel->id.'" type="submit" formaction="/delete_duel">Decline</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>';
            }
            else
            {
                $html.='<div class="collapse detail" id="card-current-'.$duel->id.'">
                <div class="center-mobil txt-blck all-width">
                    <h4 class="card-view-title">'.$duel->tittle.'</h4>
                    <p class="card-view-description">'.$duel->Description.'</p>
                    <p class="card-view-date">Start Date: '.$duel->startDate.'</p>
                    <p class="card-view-status">Status: '.$duel->duelstatus->description.'</p>';
                if($duel->ctl_user_id_witness || $duel->ctl_user_id_challenged==$id_auth->id)
                {
                    if($duel->ctl_user_id_witness)
                    {
                        $html.='<div class="card-view-info  center-mobil">
                            <div class="row">
                                <div class="col-6 offset-3">
                                    <div class="row">
                                        <div class="col center-mobil">
                                            <h5 class="witness-info-title">Witness</h5>
                                            <p class="witness-info-text">'.$duel->ctlUser2->username.'</p>
                                        </div>
                                        <div class="col center-mobil">
                                            <h5 class="witness-info-title">Comission</h5>
                                            <p class="witness-info-text">'.$duel->witness_comision.'%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                }
                else if($duel->ctl_user_id_challenger==$id_auth->id && $duel->duelstate==4 || $duel->duelstate==9)
                {
                    $html.='<form action="#" method="GET" class="card-view-info center-mobil">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <h4 class="card-view-cw-title">Choose Winner</h4>
                        <div class="row col-6 offset-3">
                            <div class="col center-mobil">
                                <button class="first-player-button" type="submit" formaction="/update_balance/'.$duel->id.'/'.$duel->ctl_user_id_challenged.'/'.$duel->ctl_user_id_challenger.'">'.$duel->ctlUser1->username.'</button>
                            </div>
                            <div class="col center-mobil">
                                <button class="second-player-button" type="submit" formaction="/update_balance/'.$duel->id.'/'.$duel->ctl_user_id_challenger.'/'.$duel->ctl_user_id_challenged.'" >'.$duel->ctlUser0->username.'</button>
                            </div>
                        </div>
                    </form>';
                }
            }
            $html.='</div>
                </td>
            </tr>';
        }
        $html.='</tbody>
        </table>';

        echo $html;
    }
    //----------------- END OF CURRENT DEWLS UPDATE FUNCTION ------------

    //----------------- WITNESS DEWLS UPDATE FUNCTION -------------------
    public function updateWitnessDewls(){
        $id_auth=Auth::user();
        $record_witness=duels::with('ctlUser0','ctlUser3', 'duelstatus')->where([['ctl_user_id_witness','=',$id_auth->id],['duelstate','!=',6]])->orWhere([['ctl_user_id_witness','=',$id_auth->id],['duelstate','!=',8]])->orderBy('id', 'desc')->get();
        $counter = count($record_witness);
        $html = '<table class="table table-borderless">
            <thead style="color: #08ADD5;">
                <tr>
                    <th colspan="4 center" style="color:#000"><strong>Serving as Witness '.$counter.'id'.$id_auth->id.'</strong></th>
                </tr>
            </thead>
            <tbody>';

        foreach($record_witness as $witness){
            $html.='<tr>
            <td colspan="4">
                <div class="card-table">
                    <div class="short-desc">
                        <div class="row"  data-toggle="collapse" href="#witness-collapse-'.$witness->id.'" role="button" aria-expanded="false" aria-controls="witness-collapse-'.$witness->id.'">
                            <div class="col-md-5 current-card-column"><strong>'.$witness->ctlUser0->username.' VS '.$witness->ctlUser1->username.'</strong></div>
                            <div class="col-md-3 col-7 current-card-column"><strong>'.$witness->pot.' stacks</strong></div>
                            <div class="col-md-2 col-3 current-card-column"><strong>DATA</strong></div>
                            <div class="col-md-1 col-2 current-card-column"><i class="fas fa-exclamation notification-icon"></i></div>
                        </div>
                    </div>
                    <div class="collapse detail" id="witness-collapse-'.$witness->id.'">
                        <div class="center-mobil text-center chwin-content">';
            if($witness->duelstate==2 || $witness->duelstate==3 || $witness->duelstate==10 || $witness->duelstate==11)
            {
                $html.='<h4 class="card-view-title" style="color:black;font-size:18px;">
                You have been invited as a Witness to this Dewl. <br>
                Please select your Witness Percentage.
                </h4>
                <form action="#" method="post" class="choose-winner">
                <input type="hidden" name="_token" value="'.csrf_token().'">';

                if($witness->ctlUser1->review_avg<2.5)
                {
                    $html.='<p style="border: 0px solid #761b18; color: #761b18;border-radius:5px;margin:5px;font-size:15px;font-weight:800;padding:3px;">
                        '.$witness->ctlUser1->username.' is a sore loser
                    </p>';
                }
                else if($witness->ctlUser0->review_avg<2.5)
                {
                    $html.='<p style="border: 0px solid #761b18; color: #761b18;border-radius:5px;margin:5px;font-size:15px;font-weight:800;padding:3px;">
                        '.$witness->ctlUser0->username.' is a sore loser
                    </p>';
                }

                $html.='<div class="row ">
                        <div class=" col-lg-12 ">
                            <input type="number" name="percentage" min="1" max="7" id="input'.$witness->id.'">
                            <input type="text" value="'.$witness->id.'" name="id" hidden>
                        </div>
                    </div>
                    <br>
                    <div class="row text-center">
                        <div class="row col-6 offset-3">
                            <div class="col-6">
                                <button class="btn-primary btn-primary btn btn'.$witness->id.'" style="background-color: #00B6E3;" id="acept'.$witness->id.'" type="submit" formaction="/witn_validate">Accept</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-danger" style="background-color: #D5130B" id="refuse'.$witness->id.'" type="submit" formaction="/nowith">Decline</button>
                            </div>
                        </div>
                    </div>
                </form>';
            }
            else if($witness->duelstate==1)
            {
                $html.='<div class="center-mobil txt-blck all-width">
                    <h4 class="card-view-title">'.$witness->tittle.'</h4>
                    <p class="card-view-description">'.$witness->Description.'</p>
                    <p class="card-view-date">Start Date: '.$witness->startDate.'</p>
                    <p class="card-view-status">Status: '.$witness->duelstatus->description.'</p>
                </div>';
            }
            else
            {
                if($witness->duelstate==4 or $witness->duelstate==9)
                {
                    $html.='<form action="#" method="post" class="choose-winner">
                        <h4>Choose the winner</h4>
                        <div class="col-md-8 offset-md-2 col-12">
                            <div class="row choose-winner-row">
                                <div class="col-md-5 col-5 witness-player-selector">
                                    <button type="button" class="btn btn-primary player-1">'.$witness->ctlUser0->username.'</button>
                                </div>
                                <div class="col-md-2 col-2 d-flex align-items-center justify-content-center">
                                    <h4 cl>VS</h4>
                                </div>
                                <div class="col-md-5 col-2 witness-player-selector">
                                    <button type="button" class="btn btn-primary player-2">'.$witness->ctlUser1->username.'</button>
                                </div>
                            </div>
                        </div>
                    </form>';
                }
            }

            $html.='</div>
                    </div>
                </td>
            </tr>
                                <!--div class="choose-winner ">
                                <h4>Choose the winner</h4>
                                    <div class="col-md-8 offset-md-2 col-12">
                                        <div class="row choose-winner-row">
                                            <div class="col-md-5 col-5 witness-player-selector">
                                                <button type="button"
                                                        class="btn btn-primary player-1">'.$witness->ctlUser0->username.'</button>
                                            </div>
                                            <div
                                                class="col-md-2 col-2 d-flex align-items-center justify-content-center">
                                                <h4 cl>VS</h4>
                                            </div>
                                            <div class="col-md-5 col-2 witness-player-selector">
                                                <button type="button"
                                                        class="btn btn-primary player-2">'.$witness->ctlUser1->username.'</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="r-u-sure ">
                                    <h4>Confirm Alex Won the Dewl?</h4>
                                    <div class="col-md-8 offset-md-2 col-12">
                                        <div class="row justify-content-center">
                                            <div class="col-md-6 col-6"><button type="button" class="btn btn-success">Yes</button></div>
                                            <div class="col-md-6 col-6"> <button type="button" class="btn btn-danger">No</button></div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr-->';
        }

        $html.='</tbody>
        </table>';

        echo $html;
    }
}
