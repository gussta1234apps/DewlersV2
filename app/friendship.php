<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class friendship extends Model
{
        public function ctl_users()
        {
            return $this->belongsTo('App\ctl_users');
        }
}
