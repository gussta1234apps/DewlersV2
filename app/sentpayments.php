<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $duel_id
 * @property int $id
 * @property string $description
 * @property int $status
 * @property string $registerDate
 * @property string $billingDate
 * @property int $sentPaymentStatus_id
 * @property float $amount
 * @property Duel $duel
 * @property Sentpaymentstatus $sentpaymentstatus
 */
class sentpayments extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['duel_id', 'id', 'description', 'status', 'registerDate', 'billingDate', 'sentPaymentStatus_id', 'amount'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function duel()
    {
        return $this->belongsTo('App\Duel');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sentpaymentstatus()
    {
        return $this->belongsTo('App\Sentpaymentstatus', 'sentPaymentStatus_id');
    }
}
