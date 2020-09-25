<?php

namespace App\Http\Controllers;

use App\ctl_users;
use App\Notifications\addfriend;
use App\Notifications\send_req_friend;
use App\Notifications\StatusUpdate;
use App\User;
use App\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\internalaccounts;
use App\duels;
use Illuminate\Support\Facades\Notification;
//use Frie/

class UserController extends Controller
{
    //
    public function tmanager()
    {
        //
        $id = Auth::user();
        $balance =  internalaccounts::with('ctlUser')->where('id','=',$id->id)->first();
        return view('UserMenu.transactionmanager')->with('balance',$balance);
    }
    public function addcoins(Request $request){
        $id = Auth::user();
        $amount = $request->input('option');
        $ownAmount = $request->input('ownAmount');
        $amount = $request->input('amount');
        $actualamount = DB::table('internalaccounts')->where('id','=',$id->id)->first();
        //            Si el valor del OwnAmount esta vacion obtenemos el de los radiobutton
        if(empty( $ownAmount)){
            $newAmount = $actualamount->balance + (float)$amount;
        }
        else{
            $newAmount = $actualamount->balance + (float)$ownAmount;
        }

        error_log('Some message here.');
        DB::table('internalaccounts')
            ->where('id','=',$id->id)
            ->update(['balance'=>$newAmount]);

        return redirect('/transactionmanager');
    }

    public  function witness(){

        $id=Auth::user();

        $duels=duels::with('ctlUser0','ctlUser1')->where('ctl_user_id_witness','=',$id->id)->get();
        $don_status =  DB::table('double_or_nothing')->where('loser_id',$id);  //se enviara para comparar si el don debe repetirse o no
        $witness_acept=0;

        return view('UserMenu.witness')->with('duels',$duels)->with('don_status',$don_status)->with('witness_acept',$witness_acept); // se enviara para evitar que el witness pueda ver este duelo se ocupara si es necesario.
    }

    //FUNCION PARA DECIDIR GANADOR SI SE ES EL CREADOR DEL DUELO
    //
    //SELECCIONAR DE LA BASE LOS DUELOS CON WITNESS VACIO Y QUE EL USUARIO LOGUEADO SEA EL CHALLENGER

    public function challenger_decides(){
        $id=Auth::user();

        $no_witness= duels::with('ctlUser0', 'ctlUser1')->where([['ctl_user_id_witness', '=', null],['ctl_user_id_challenger','=', $id->id]]);

    }

        public function witness_contract(Request $request){

        $id = Auth::user();
        $percen = $request->input("percentage");
        $percentage=$percen/100;
        $duel=$request->input("id");

        $defore_update= DB::table('duels')->where('id','=',$duel)->first();

        //CONFRONTA CON LA BASE ESTOS DATOS SINO TE VAS A PERDER

        if($defore_update->duelstate==2){

            DB::table('duels')->where('id',$defore_update->id)->update(['duelstate'=>1]);
            DB::table('duels')->where('id',$defore_update->id)->update(['witness_comision'=>$percen]);
//            DB::table('duels')->insert(['witness_comision'=>$percentage]);

        }elseif ($defore_update->duelstate==3){
            DB::table('duels')->where('id',$defore_update->id)->update(['duelstate'=>4]);
            DB::table('duels')->where('id',$defore_update->id)->update(['witness_comision'=>$percen]);
//            DB::table('duels')->insert(['witness_comision'=>$percentage]);

        }elseif ($defore_update->duelstate==10){
            DB::table('duels')->where('id',$defore_update->id)->update(['duelstate'=>7]);
            DB::table('duels')->where('id',$defore_update->id)->update(['witness_comision'=>$percen]);
//            DB::table('duels')->insert(['witness_comision'=>$percentage]);

        }elseif ($defore_update->duelstate==11){
            DB::table('duels')->where('id',$defore_update->id)->update(['duelstate'=>9]);
            DB::table('duels')->where('id',$defore_update->id)->update(['witness_comision'=>$percen]);
//            DB::table('duels')->insert();
        }



        //if duelstate==2 estado cambia a 1
        //if duelstate==3 estado cambia a 4
        //if duelstate==10 estado cambia a 7
        //if duelstate==11 estado cambia a 9


        $duels_data= DB::table('duels')->where('id','=',$duel)->first();


        //-----------------------------------CORREOS WINNER--------------------------------------------


        $email_challenger=User::where('id','=',$duels_data->ctl_user_id_challenger)->first();//WINNER
        $email_witness=User::where('id','=',$duels_data->ctl_user_id_witness)->first();//LOSS

        $arr5=[$duels_data->tittle,5,$email_challenger->name, $email_witness->name]; //DATA FOR EMAIL TEMPLATE WINNER
        ///Notification::route('mail', $email_challenger->email)
        //    ->notify(new StatusUpdate($arr5)); //EMAIL FOR WINNER


        return redirect('/dashboard');

    }

        public function witness_refuse(Request $request){

        $id = Auth::user();
        $percentage = $request->input("percentage");

        $duel=$request->input("id");

        $duels_data= DB::table('duels')->where('id','=',$duel)->first();

        if($duels_data->duelstate==2){

            DB::table('duels')
                ->where('id','=',$duel)
                ->update(['ctl_user_id_witness'=>null]);

            DB::table('duels')
                ->where('id','=',$duel)
                ->update(['duelstate'=>1]);

        }elseif ($duels_data->duelstate==3){

            DB::table('duels')
                ->where('id','=',$duel)
                ->update(['ctl_user_id_witness'=>null]);

            DB::table('duels')
                ->where('id','=',$duel)
                ->update(['duelstate'=>1]);

        }elseif ($duels_data->duelstate==10){

            DB::table('duels')
                ->where('id','=',$duel)
                ->update(['ctl_user_id_witness'=>null]);

            DB::table('duels')
                ->where('id','=',$duel)
                ->update(['duelstate'=>7]);

        }elseif ($duels_data->duelstate==11){

            DB::table('duels')
                ->where('id','=',$duel)
                ->update(['ctl_user_id_witness'=>null]);

            DB::table('duels')
                ->where('id','=',$duel)
                ->update(['duelstate'=>9]);

        }





        //-----------------------------------CORREOS WINNER--------------------------------------------


        $email_challenger=User::where('id','=',$duels_data->ctl_user_id_challenger)->first();//WINNER
        $email_challenged=User::where('id','=',$duels_data->ctl_user_id_challenged)->first();//WINNER
        $email_witness=User::where('id','=',$duels_data->ctl_user_id_witness)->first();//LOSS

        $arr5=[$duels_data->tittle,6,$email_challenger->name, $email_witness->name]; //DATA FOR EMAIL TEMPLATE WINNER
        //Notification::route('mail', $email_challenger->email)
          //  ->notify(new StatusUpdate($arr5)); //EMAIL FOR WINNER

        $arr5=[$duels_data->tittle,6,$email_challenger->name, $email_witness->name]; //DATA FOR EMAIL TEMPLATE WINNER
       // Notification::route('mail', $email_challenged->email)
            //->notify(new StatusUpdate($arr5)); //EMAIL FOR WINNER

        return redirect('/dashboard');



    }

    public function myaccount(){

        $id = Auth::user();

        $ctl_log_user= ctl_users::where('id','=',$id->id)->first();

        $resquet_pending= $ctl_log_user->getFriendRequests();
        $friends=$ctl_log_user->getFriends();

        return view('UserMenu/myaccount')->with('pending_f_req',$resquet_pending)->with('friends',$friends);

    }

    public function accept_friend($id_accept){

        $user = Auth::user();
        $me_user=ctl_users::where('id',$user->id)->first();
        $sender_friend=ctl_users::where('id',$id_accept)->first();
        $frien_email=User::where('id',$id_accept)->first();

        $me_user->acceptFriendRequest($sender_friend);

        $arr5=[$me_user->username]; //DATA FOR EMAIL TEMPLATE WINNER
        Notification::route('mail', $frien_email->email)
            ->notify(new addfriend($arr5)); //EMAIL FOR WINNER

        return redirect('/myaccount');
    }

    public function refuse_friend($id_accept){

        $user = Auth::user();
        $me_user=ctl_users::where('id',$user->id)->first();
        $sender_friend=ctl_users::where('id',$id_accept)->first();

        $me_user->denyFriendRequest($sender_friend);

        return redirect('/myaccount');
    }

    public function send_friend(Request $request){

        $id_recipient=$request->input('user_id');

        $user = Auth::user();
        $me_user=ctl_users::where('id',$user->id)->first();
        $recipient=ctl_users::where('id',$id_recipient)->first();
        $frien_email=User::where('id',$id_recipient)->first();

        $me_user->befriend($recipient);

        $arr5=[$me_user->username]; //DATA FOR EMAIL TEMPLATE WINNER
        //Notification::route('mail', $frien_email->email)
        //    ->notify(new send_req_friend($arr5)); //EMAIL FOR WINNER

        return redirect('/dashboard');
//        return view('test')->with('like',$container);/

    }

    public function search_person(Request $request){

        $name = $request->input('user');
        $user_requested= User::where('name','LIKE','%'.$name.'%')->orwhere('email','LIKE','%'.$name.'%')->get();

                if($user_requested->isNotempty()){
            $flag=0;
            return view('UserMenu.search')->with("selected",$user_requested)->with('flag',$flag);

        }else{
            $flag=1;
            return view('UserMenu.search')->with("selected",$user_requested)->with('flag',$flag);
        }
    }

    //- SEARCH DEWLER FUNCTION
    public function searchDewler($dewlerName){
        $name = $dewlerName;
        $user_requested= User::where('name','LIKE','%'.$name.'%')->orwhere('email','LIKE','%'.$name.'%')->get();

        //- get friends
        $id_auth=Auth::user();
        $me_user=ctl_users::where('id',$id_auth->id)->first();
        $friends=$me_user->getFriends();


        $resquet_pending= $me_user->getFriendRequests();

        if($user_requested->isNotempty()){

            $html = '<h5>Dewler Search Results</h5>';
            $collections = '';
            foreach($user_requested as $user)
            {
                $isFriend   = false;
                $isPending  = false;
                foreach($friends as $friend){
                    if($user->id == $friend->id){$isFriend=true;}
                }

                $search_requests=ctl_users::where('id',$user->id)->first();
                $resquet_pending= $search_requests->getFriendRequests();

                foreach($resquet_pending as $pending){
                    if($id_auth->id == $pending->sender->id){$isPending=true;}
                }

                $buttons = "";

                if($isFriend){
                    $buttons = '<button class="friends-dewl-button">Create Dewl</button>
                    <button class="friends-remove-button">Remove</button>';
                }else if($isPending){
                    $buttons = '<button class="friends-add-button" disabled>Pending</button>';
                }else{
                    $buttons = '<button class="friends-add-button" type="submit" formaction="/send_f_request">Add</button>';
                }

                $html       .='<div class="friends-info-card"><form action="#"> <input type="text" name="user_id" id="id_user" value="'.$user->id.'" hidden>'.$buttons.'<p class="friends-info-name">'.$user->name.'</p>
               </form></div>';
            }

            echo $html;
        }else{
            echo "No-users";
        }
    }
    //- END OF SEARCH DEWLER FUNCTION

        public function get_review(Request $request){
        $user = Auth::user();
        $review= new Reviews;
        $review->description = $request->input('review');
        $review->stars= $request->input('stars');
        $review->rol= $request->input('id');
        $review->user = $user->id;
        $review->save();

        $average = DB::table('reviews')->where('user',$user->id)->groupBy('user')->avg('stars');

        DB::table('ctl_users')->where('id', $user->id)->update(['review_avg'=>$average]);

        $duelid=$request->input('id');

        $du=duels::where('id',$duelid)->first();

if($user->id==$du->ctl_user_id_winner){

            DB::table('duels')
                ->where('id','=',$du->id)
                ->update(['winner_review'=>1]);

        }else{
            DB::table('duels')
                ->where('id','=',$du->id)
                ->update(['loser_review'=>1]);
        }

        return redirect('/dashboard');
    }

}
