<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $rol
 * @property CtlUser[] $ctlUsers
 */
class ctl_rols extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['rol'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ctlUsers()
    {
        return $this->belongsToMany('App\CtlUser', 'ctl_rol_users');
    }
}
