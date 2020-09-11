<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $ctl_user_id
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $birthDate
 * @property string $registerDate
 * @property string $modificationDate
 * @property string $photography
 * @property CtlUser $ctlUser
 */
class persons extends Model
{
    const CREATED_AT = 'registerDate';
    const UPDATED_AT = 'modificationDate';
    /**
     * @var array
     */
    protected $fillable = ['ctl_user_id', 'firstName', 'lastName', 'email', 'birthDate', 'registerDate', 'modificationDate', 'photography'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ctlUser()
    {
        return $this->belongsTo('App\CtlUser');
    }
}
