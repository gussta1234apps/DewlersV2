<?php

namespace App\Http\Controllers;

use App\ctl_users;
use App\internalaccounts;
use App\Notifications\delete_dewl;
use App\Reviews;
use App\category_users;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\duels;
use App\double_or_nothing;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StatusUpdate;


class DuelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();


        $challengeds= DB::table('ctl_users')->where('id','!=',$user->id)->get();
        return view('Duels.createduel')->with('challengeds',$challengeds);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();
//        $challenger=DB::table('')


        $tittle=$request->post('tittle');
        $user_challenger=$user->id;
        $user_challenged=$request->post('challendged');
        $description=$request->post('description');
        $user_witness=$request->post("witness");
        $start= $request->post("startdate");
        $end='2020-02-10';
        $file='1';
        $status=1;
        $witness_validate= $request->post('witness_validate');
//        $user_winner=;
        $duel_state=2;
        $pot=$request->post('pot');


        //EMAIL NOTIFICATION

        $email_challenged=User::where('id','=',$user_challenged)->first(); //CHALLENGED data from user FOR EMAIL
        $email_witness=User::where('id','=',$user_witness)->first(); //WITNESS DATA FROM USER(MODEL) FOR EMAIL

       // $arr=[$user->name,0,$email_challenged->name,$tittle]; //DATA FOR EMAIL TEMPLATE CHALLENGER
        //[0] Nombre del retador
        //[1] Identificador dentro de status update
        //[2] Nombre del retado
        //[3] Titulo del dewl

        /*
        Notification::route('mail', $email_challenged->email)
            ->notify(new StatusUpdate($arr)); //EMAIL FOR CHALLENGED
 */

        if($witness_validate!="on"){
            $user_witness=null;
            $duel_state=1;
        }else{
            $arr2=[$user->name,1,$email_witness->name,$tittle]; //DATA FOR EMAIL TEMPLATE WITNESS
           /* Notification::route('mail', $email_witness->email)
                ->notify(new StatusUpdate($arr2)); //EMAIL FOR WITNESS*/
        }

        DB::table('duels')->insert(["tittle"=>$tittle,
            'ctl_user_id_challenger'=>$user_challenger,
            'ctl_user_id_challenged'=>$user_challenged,
            'ctl_user_id_witness'=>$user_witness,
            'registerDate'=>date("Y-m-d") ,
            'modificationDate'=>$start,
            'startDate'=>$start,
            'endDate'=>$end,
            'testFile'=>$file,
            'status'=>$status,
            'duelstate'=>$duel_state,
            'pot'=>$pot,
            'Description'=>$description]);


//        return view('UserMenu.index'); che
        return redirect("dashboard");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function  status()
    {
        $id_auth=Auth::user();
        $due2=duels::with('ctlUser0','ctlUser3', 'duelstatus')->where('ctl_user_id_challenger','=',$id_auth->id)->orWhere('ctl_user_id_challenged','=',$id_auth->id)->get();;
        $don_status=DB::table('double_or_nothing')->where('loser_id',$id_auth)->get();  //se enviara para comparar si el don debe repetirse o no
        $don_status=double_or_nothing::where('loser_id', '=', $id_auth)->get();

//        foreach ($don_status as $don){
//            echo $don->status;
//        }


//        if($don_status==null){
//            $id = Auth::user();
//
//            $actualamount = DB::table('internalaccounts')->where('id','=',$id->id)->first();
//
//            return view('UserMenu.index')->with('actualamount',$actualamount->balance);
//        }else{


        return view('Duels.status')->with('duels',$due2)->with('don_status',$don_status);
//        }
    }

    public function gamewinner($idduel,$idwinner,$idlosser){//      PLAYERS IDS
        $id_winner=$idwinner;
        $id_loser=$idlosser;
        $id_auth=Auth::user();
        $user=Auth::user();
//        ----------------------------------------------------------------------------------------------


        //        TEST DUEL BALANCE
        $duel_id=$idduel;

        //        POT DEL DUELO
        $duels_pot_data=duels::where('id','=',$duel_id)->first();
        $pot=$duels_pot_data->pot;

        //- View state set
        $newStateCondition = false;
        $newViewState = $duels_pot_data->testFile;
        if($duels_pot_data->ctl_user_id_witness){
            if($duels_pot_data->ctl_user_id_witness==$id_auth->id){
                $newViewState = 3;
                $newStateCondition = true;
            }
        }else{
            $newViewState = 1;
            $newStateCondition = true;
        }

        //witness comision

        //-----------------------------------CORREOS WINNER--------------------------------------------


        $email_winner=User::where('id','=',$id_winner)->first();//WINNER
        $email_loser=User::where('id','=',$id_loser)->first();//LOSS

        $arr3=[$duels_pot_data->tittle,2,$email_winner->name]; //DATA FOR EMAIL TEMPLATE WINNER
        Notification::route('mail', $email_winner->email)
            ->notify(new StatusUpdate($arr3)); //EMAIL FOR WINNER

        //-----------------------------------CORREOS LOSS--------------------------------------------



        $arr4=[$duels_pot_data->tittle,3,$email_loser->name,$email_winner->name]; //DATA FOR EMAIL TEMPLATE LOSS
        Notification::route('mail', $email_loser->email)
            ->notify(new StatusUpdate($arr4)); //EMAIL FOR LOSS


//        TEST DUEL BALANCE
        $duel_id=$idduel;

        if($duels_pot_data->duelstate==9){

            DB::table('duels')->where('id', $duel_id)->update(['ctl_user_id_winner'=>$id_winner,'ctl_user_id_loser'=>$id_loser, 'duelstate'=>8, 'status'=>2,'don'=>2, 'testFile'=>$newViewState]);
        }else{
            DB::table('duels')->where('id', $duel_id)->update(['ctl_user_id_winner'=>$id_winner,'ctl_user_id_loser'=>$id_loser, 'duelstate'=>6, 'status'=>0,'don'=>1, 'testFile'=>$newViewState]);
        }







        //        COMPROBACION SI EL DEWL TIENE O NO WITNESS
        $nowitness= $duels_pot_data->ctl_user_id_witness;

        //division del pot
        $pot_dewlers=$pot*0.1;

        if ($nowitness==null){
            $pot_winner=$pot*0.9;
            DB::table('duels')->where('id', $duel_id)->update(['winner_review'=>1, 'loser_review'=>1]);
        }
        else{
           $com= $duels_pot_data->witness_comision; //comision que viene del witness VIENE ENTERO

            $comision=$com/100;  //Se divide entre 100 para sacar el decimal

            $winner_entero= 90-$com;  // cantidad entera del ganador menos 90 que es lo que quedo de quitarle lo del witness

            $winner_double= $winner_entero/100;

            $pot_witness= $pot*$comision; // se multiplica el dinero que viene poor la comision que esta

            $pot_winner= $pot*$winner_double; // se multiplica la cantidad total del pot por el 85%

            if($duels_pot_data->duelstate==7){

                DB::table('duels')->where('id', $duel_id)->update(['winner_review'=>1, 'loser_review'=>1]);

            }

            //INTERNAL WITNESS ACCOUNT BALANCE
            $id_witness=$duels_pot_data->ctl_user_id_witness;// se obtiene el id de el witness
            $data_witness_balance=internalaccounts::where('ctl_user_id',$id_witness)->first(); //se obtiene la row donde esta la cuenta interna de el witness
            $plus_balance_witness=$data_witness_balance->balance + $pot_witness;
            DB::table('internalaccounts')->where('ctl_user_id',$id_witness)->update(['balance'=>$plus_balance_witness]);
        }

//        INTERNAL WINNER ACCOUNT BALANCE
        $data_winner_balance=internalaccounts::where('ctl_user_id',$id_winner)->first();
        $plus_balance=$data_winner_balance->balance + $pot_winner;
//        return View('test')->with('like',$plus_balance);

//        UPDATING WINNER INTERNAL ACCOUNT
        DB::table('internalaccounts')->where('ctl_user_id',$id_winner)->update(['balance'=>$plus_balance]);


//        INTERNAL LOSER ACCOUNT BALANCE
        $data_loser_balance=internalaccounts::where('ctl_user_id',$id_loser)->first();
        $less_balance=$data_loser_balance->balance - $pot;


//          UPDATING LOSER ACCOUNT BALANCE
        DB::table('internalaccounts')->where('ctl_user_id',$id_loser)->update(['balance'=>$less_balance]);


        //create double or nothing dependiendo del perdedor
        DB::table('double_or_nothing')->insert(["duel_id"=>$duel_id,
            'status'=>1,
            'loser_id'=>$id_loser]);



        //Creation of reviews and user_category
        //Winner Review
       // DB::table("Reviews")->insert(['description'=>'The witness was very good','stars'=>4,'created_at'=>date('y-m-d H:i:s'),'rol'=>'Winner','duel'=>$idduel,'user'=>$idwinner]);

        //Winner Review Count
        //$winner_review_count=DB::table('Reviews')->where('user','=',$idwinner)->avg('stars');
       // DB::table('category_users')->where('user',$idwinner)->update(['avg'=>$winner_review_count]);

        //Loser Review
       // DB::table("Reviews")->insert(['description'=>'The witness was very bad','stars'=>2,'created_at'=>date('y-m-d H:i:s'),'rol'=>'Loser','duel'=>$idduel,'user'=>$idlosser]);
        //Loser Review Count
        //$loser_review_count=DB::table('Reviews')->where('user','=',$idlosser)->avg('stars');
        //DB::table('category_users')->where('user',$idlosser)->update(['avg'=>$loser_review_count]);

        return redirect('/dashboard');

    }

    public function acept_challenge($id){

        DB::table('duels')->where('id',$id)->update(['duelstate'=>2]);
        return redirect('/status');

    }

    public function dewl_challenged_acept(Request $request){

        $id_duel_acepted=$request->post('id');
        $status_duel=duels::where("id",$id_duel_acepted)->first();

        if($status_duel->duelstate==1){

            DB::table('duels')->where('id',$id_duel_acepted)->update(['duelstate'=>4]);

        }elseif ($status_duel->duelstate==2){
            DB::table('duels')->where('id',$id_duel_acepted)->update(['duelstate'=>3]);

        }elseif ($status_duel->duelstate==7){
            DB::table('duels')->where('id',$id_duel_acepted)->update(['duelstate'=>9]);

        }elseif ($status_duel->duelstate==10){
            DB::table('duels')->where('id',$id_duel_acepted)->update(['duelstate'=>11]);
        }



        return redirect('/dashboard');

    }

        public function delete_dewl(Request $request){

        $id_duel=$request->post('id');

        $to_delete= duels::find($id_duel);

        $to_delete_don= double_or_nothing::where('duel_id',$id_duel)->get();

        if ($to_delete){

            foreach ($to_delete_don as $del){

                $del->delete();
            }

        }



        $to_chellenger=User::find($to_delete->ctl_user_id_challenger);  //retador
        $to_chellendeg=User::find($to_delete->ctl_user_id_challenged); //desafiado



        $arr_delete=[$to_delete->tittle,1,$to_chellendeg->name]; // desafiado
        Notification::route('mail', $to_chellendeg->email)
            ->notify(new delete_dewl($arr_delete)); //EMAIL FOR chellenged



        $arr_delete=[$to_delete->tittle,1,$to_chellendeg->name]; // retador
        Notification::route('mail', $to_chellenger->email)
            ->notify(new delete_dewl($arr_delete)); //EMAIL FOR chellenger

        if($to_delete->ctluser_id_witness!=null){

            $to_witness=User::find($to_delete->ctl_user_id_witness); //desafiado

            $arr_delete=[$to_delete->tittle,1,$to_chellendeg->name]; // retador
            Notification::route('mail', $to_witness->email)
                ->notify(new delete_dewl($arr_delete)); //EMAIL FOR chellenger

        }

        $to_delete->delete();



        return redirect('/dashboard');
    }


}
