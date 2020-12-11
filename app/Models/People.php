<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *  @OA\Schema(
 *     schema="Person",
 *     type="object",
 *     title="Person",
 *     description="Person Imported",
 *     properties={  
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="phones", type="array", @OA\Items(ref="#/components/schemas/Phone")),
 *         @OA\Property(property="shiporders", type="array", @OA\Items(ref="#/components/schemas/Shiporder"))
 *     }
 *  )
 *
 */
class People extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name'];
    protected $with = ['phones', 'shiporders'];


    /**
     * @OA\Schema(
     *     schema="Phone",
     *     type="object",
     *     title="Phone",
     *     description="Phone of person",
     *     properties={  
     *         @OA\Property(property="number", type="string")     
     *     }
     *  )
     */
    public function phones()
    {
        return $this->hasMany('App\Models\Phones', 'person_id', 'id');
    }


    public function shiporders()
    {
        return $this->hasMany('App\Models\Shiporders', 'person_id', 'id');
    }
}
