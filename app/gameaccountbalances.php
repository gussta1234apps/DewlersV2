<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $duel_id
 * @property string $movementDate
 * @property float $movementAmount
 * @property int $status
 * @property int $internalAccount_id
 * @property Duel $duel
 * @property Internalaccount $internalaccount
 */
class gameaccountbalances extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['duel_id', 'movementDate', 'movementAmount', 'status', 'internalAccount_id'];

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
    public function internalaccount()
    {
        return $this->belongsTo('App\Internalaccount', 'internalAccount_id');
    }
}
