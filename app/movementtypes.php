<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $description
 * @property int $status
 * @property string $registerDate
 * @property string $modificationDate
 * @property Internalaccountmovement[] $internalaccountmovements
 * @property Stripemovementaccount[] $stripemovementaccounts
 */
class movementtypes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['description', 'status', 'registerDate', 'modificationDate'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function internalaccountmovements()
    {
        return $this->hasMany('App\Internalaccountmovement', 'movementType');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stripemovementaccounts()
    {
        return $this->hasMany('App\Stripemovementaccount', 'movementType');
    }
}
