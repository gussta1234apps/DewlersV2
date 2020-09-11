<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $registerDate
 * @property string $systemRegisterDate
 * @property float $amount
 * @property string $inPayment
 * @property string $description
 * @property int $internalAccount_id
 * @property int $movementType
 * @property Internalaccount $internalaccount
 * @property Movementtype $movementtype
 */
class internalaccountmovements extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['registerDate', 'systemRegisterDate', 'amount', 'inPayment', 'description', 'internalAccount_id', 'movementType'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function internalaccount()
    {
        return $this->belongsTo('App\Internalaccount', 'internalAccount_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movementtype()
    {
        return $this->belongsTo('App\Movementtype', 'movementType');
    }
}
