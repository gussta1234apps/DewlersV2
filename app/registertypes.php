<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $description
 * @property int $status
 * @property CtlUser[] $ctlUsers
 */
class registertypes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['description', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ctlUsers()
    {
        return $this->hasMany('App\CtlUser', 'registerType_id');
    }
}
