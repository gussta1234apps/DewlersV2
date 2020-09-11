<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $token
 * @property string $accountNumber
 * @property string $cardNumber
 * @property string $expireDate
 * @property string $activationDate
 * @property int $activationStatus
 * @property int $status
 */
class systeminternalaccounts extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['token', 'accountNumber', 'cardNumber', 'expireDate', 'activationDate', 'activationStatus', 'status'];

}
