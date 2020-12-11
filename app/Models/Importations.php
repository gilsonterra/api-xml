<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Importations extends Model
{
    use HasFactory;

    const PENDING = 'pending';
    const IMPORTING = 'importing';
    const IMPORTED_WITH_SUCCESS = 'imported_with_success';
    const IMPORTED_WITH_ERROR = 'imported_with_error';

    protected $guarded = ['id'];
    protected $hidden = ['path'];
    protected $appends = ['link_api'];

    public function getLinkApiAttribute(){
        return sprintf('%s/%s', url('api'), $this->attributes['type']);
    }
}
