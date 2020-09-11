<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $ctl_user_id_challenger
 * @property int $ctl_user_id_challenged
 * @property int $ctl_user_id_witness
 * @property int $ctl_user_id_winner
 * @property int $duelstate
 * @property string $tittle
 * @property string $registerDate
 * @property string $modificationDate
 * @property string $startDate
 * @property string $endDate
 * @property string $testFile
 * @property int $status
 * @property float $pot
 * @property CtlUser $ctlUser0
 * @property CtlUser $ctlUser1
 * @property CtlUser $ctlUser2
 * @property CtlUser $ctlUser3
 * @property duelstatuses $duelstatuses
 * @property Gameaccountbalance[] $gameaccountbalances
 * @property Sentpayment[] $sentpayments
 */
class duels extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['ctl_user_id_challenger', 'ctl_user_id_challenged', 'ctl_user_id_witness', 'ctl_user_id_winner', 'duelstate', 'tittle', 'registerDate', 'modificationDate', 'startDate', 'endDate', 'testFile', 'status', 'pot'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ctlUser0()
    {
        return $this->belongsTo('App\ctl_users', 'ctl_user_id_challenger');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ctlUser1()
    {
        return $this->belongsTo('App\ctl_users', 'ctl_user_id_challenged');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ctlUser2()
    {
        return $this->belongsTo('App\ctl_users', 'ctl_user_id_witness');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ctlUser3()
    {
        return $this->belongsTo('App\ctl_users', 'ctl_user_id_winner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function duelstatus()
    {
        return $this->belongsTo('App\duelstatuses', 'duelstate');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gameaccountbalances()
    {
        return $this->hasMany('App\gameaccountbalance');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentpayments()
    {
        return $this->hasMany('App\sentpayment');
    }
}
