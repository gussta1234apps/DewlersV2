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
       // $starsCount[3]+=1;$reviewsCount+=1;

        //- Hype rating avg
        try{
            $hype           = $reviews/$reviewsCount;
            $hypeRating     = ($hype*100)/5;

        }catch(Exception $ex){
            $haveHypeRating = false;
        }

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
                                <div class="col-1 current-card-column"><em class="fas fa-clock"></em></div>
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
                                @csrf
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
                                @csrf
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
                                @csrf
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
                                @csrf
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
                        @csrf
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
}
