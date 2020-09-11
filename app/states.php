<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property int $status
 * @property string $registerDate
 * @property string $modificationDate
 * @property Country $country
 * @property CtlUser[] $ctlUsers
 */
class states extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['country_id', 'name', 'status', 'registerDate', 'modificationDate'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ctlUsers()
    {
        return $this->hasMany('App\CtlUser');
    }
}
