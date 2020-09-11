<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $ctl_user_id
 * @property string $code
 * @property string $registerDate
 * @property string $modificationDate
 * @property float $balance
 * @property int $status
 * @property CtlUser $ctlUser
 * @property Gameaccountbalance[] $gameaccountbalances
 * @property Internalaccountmovement[] $internalaccountmovements
 * @property Stripeaccount[] $stripeaccounts
 */
class internalaccounts extends Model
{

    const CREATED_AT = 'registerDate';
    const UPDATED_AT = 'modificationDate';
    /**
     * @var array
     */
    protected $fillable = ['ctl_user_id', 'code', 'registerDate', 'modificationDate', 'balance', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ctlUser()
    {
        return $this->belongsTo('App\ctl_users');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gameaccountbalances()
    {
        return $this->hasMany('App\Gameaccountbalance', 'internalAccount_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function internalaccountmovements()
    {
        return $this->hasMany('App\Internalaccountmovement', 'internalAccount_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stripeaccounts()
    {
        return $this->hasMany('App\Stripeaccount', 'internalAccount_id');
    }
}
