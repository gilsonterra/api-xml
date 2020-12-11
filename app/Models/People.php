<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *  @OA\Schema(
 *     schema="PersonRequest",
 *     type="object",
 *     title="PersonRequest",
 *     description="Request of Person",
 *     properties={  
 *         @OA\Property(property="name", type="string"),
 *     }
 *  )
 * 
 *  @OA\Schema(
 *     schema="PersonResponse",
 *     type="object",
 *     title="PersonResponse",
 *     allOf={
 *          @OA\Schema(
 *              @OA\Property(property="id", type="integer"),
 *          ),
 *          @OA\Schema(ref="#/components/schemas/PersonRequest")
 *     }
 *  )
 */
class People extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name'];
    protected $with = ['phones'];

    public function phones()
    {
        return $this->hasMany('App\Models\Phones', 'person_id', 'id');
    }
}
