<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $registerDate
 * @property float $amount
 * @property string $inPayment
 * @property string $description
 * @property int $stripeAccount
 * @property int $movementType
 * @property string $systemregisterDate
 * @property Movementtype $movementtype
 * @property Stripeaccount $stripeaccount
 */
class stripemovementaccounts extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['registerDate', 'amount', 'inPayment', 'description', 'stripeAccount', 'movementType', 'systemregisterDate'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movementtype()
    {
        return $this->belongsTo('App\Movementtype', 'movementType');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stripeaccount()
    {
        return $this->belongsTo('App\Stripeaccount', 'stripeAccount');
    }
}
