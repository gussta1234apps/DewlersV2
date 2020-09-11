<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hootlex\Friendships\Traits\Friendable;

/**
 * @property int $id
 * @property int $state_id
 * @property int $ranking_id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property boolean $status
 * @property string $registerDate
 * @property string $modificationDate
 * @property string $appKey
 * @property string $code
 * @property int $rankingStatus
 * @property int $registerType_id
 * @property int $historyStatus
 * @property Ranking $ranking
 * @property Registertype $registertype
 * @property State $state
 * @property CtlRol[] $ctlRols
 * @property duels[] $duels0
 * @property duels[] $duels1
 * @property duels[] $duels2
 * @property duels[] $duels3
 * @property Internalaccount[] $internalaccounts
 * @property Person[] $persons
 */
class ctl_users extends Model
{
    use Friendable;
    /**
     * @var array
     */
    protected $fillable = ['state_id', 'ranking_id', 'username', 'password', 'salt', 'status', 'registerDate', 'modificationDate', 'appKey', 'code', 'rankingStatus', 'registerType_id', 'historyStatus'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ranking()
    {
        return $this->belongsTo('App\Ranking');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function registertype()
    {
        return $this->belongsTo('App\Registertype', 'registerType_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo('App\State');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ctlRols()
    {
        return $this->belongsToMany('App\CtlRol', 'ctl_rol_users');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function duels0()
    {
        return $this->hasMany('App\duels', 'ctl_user_id_challenger');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function duels1()
    {
        return $this->hasMany('App\duels', 'ctl_user_id_challenged');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function duels2()
    {
        return $this->hasMany('App\duels', 'ctl_user_id_witness');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function duels3()
    {
        return $this->hasMany('App\duels', 'ctl_user_id_winner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function internalaccounts()
    {
        return $this->hasMany('App\internalaccounts','ctl_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function persons()
    {
        return $this->hasMany('App\Person');
    }

    public function friendship()
    {
        return $this->hasMany('App\friendships');
    }
}
