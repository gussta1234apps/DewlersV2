<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $duel
 * @property integer $user
 * @property string $description
 * @property float $stars
 * @property string $created_at
 * @property string $updated_at
 * @property string $rol
 * @property Duel $duel0
 * @property User $user0
 */
class Reviews extends Model
{
    public $timestamps = false;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['duel', 'user', 'description', 'stars', 'created_at', 'updated_at', 'rol'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function duel()
    {
        return $this->belongsTo('App\Duel', 'duel');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user');
    }
}
