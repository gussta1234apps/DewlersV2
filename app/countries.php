<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $status
 * @property string $registerDate
 * @property string $modificationDate
 * @property State[] $states
 */
class countries extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'status', 'registerDate', 'modificationDate'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states()
    {
        return $this->hasMany('App\State');
    }
}
