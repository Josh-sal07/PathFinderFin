<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficePhoto extends Model
{
    protected $fillable = ['office_id', 'photo_path'];
    


    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}

