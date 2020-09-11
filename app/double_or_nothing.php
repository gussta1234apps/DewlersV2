<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* @property int $id
* @property int $ctl_user_id_challenger
* @property int $ctl_user_id_challenged
* @property int $ctl_user_id_witness
 */


class double_or_nothing extends Model
{
    public $primaryKey ='id';
    protected $table='double_or_nothing';

    public function duels0(){

        return $this->belongsTo('App\duels', 'duel_id');    }
}
