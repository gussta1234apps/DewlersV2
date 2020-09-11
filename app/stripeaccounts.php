<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $cardNumber
 * @property string $expirationDate
 * @property string $token
 * @property int $activationStatus
 * @property string $activationDate
 * @property int $internalAccount_id
 * @property Internalaccount $internalaccount
 * @property Stripemovementaccount[] $stripemovementaccounts
 */
class stripeaccounts extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cardNumber', 'expirationDate', 'token', 'activationStatus', 'activationDate', 'internalAccount_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function internalaccount()
    {
        return $this->belongsTo('App\Internalaccount', 'internalAccount_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stripemovementaccounts()
    {
        return $this->hasMany('App\Stripemovementaccount', 'stripeAccount');
    }
}
