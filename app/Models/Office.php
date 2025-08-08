<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    //
    protected $fillable = ['name'];

    public function photos()
{
    return $this->hasMany(OfficePhoto::class);
}



}
