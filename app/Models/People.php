<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'importation_id'];
    protected $with = ['phones'];

    public function phones()
    {
        return $this->hasMany('App\Models\Phones', 'person_id', 'id');
    }
}
