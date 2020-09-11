<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $description
 * @property string $registerDate
 * @property string $modificationDate
 * @property Duel[] $duels
 */
class duelstatuses extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['description', 'registerDate', 'modificationDate'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function duels()
    {
        return $this->hasMany('App\Duel', 'duelstate');
    }
}
