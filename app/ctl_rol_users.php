<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ctl_rol_id
 * @property int $ctl_user_id
 * @property CtlRol $ctlRol
 * @property CtlUser $ctlUser
 */
class ctl_rol_users extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['ctl_rol_id', 'ctl_user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ctlRol()
    {
        return $this->belongsTo('App\CtlRol');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ctlUser()
    {
        return $this->belongsTo('App\CtlUser');
    }
}
