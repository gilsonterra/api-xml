<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *  @OA\Schema(
 *     schema="Shiporder",
 *     type="object",
 *     title="ShipOrder",
 *     description="Ship Order from Person",
 *     properties={  
 *         @OA\Property(property="id", type="integer"), 
 *         @OA\Property(property="person", ref="#/components/schemas/Person"),
 *         @OA\Property(property="shipto_address", type="string"),
 *         @OA\Property(property="shipto_name", type="string"),
 *         @OA\Property(property="shipto_city", type="string"),
 *         @OA\Property(property="shipto_country", type="string"),
 *         @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Items"))
 *     }
 *  ) 
 *
 */
class Shiporders extends Model
{
    use HasFactory;

    protected $with = ['items'];

    protected $fillable = [
        'id', 
        'shipto_address',
        'shipto_name',
        'shipto_city',
        'shipto_country',
        'person_id',
    ];

     /**
     *@OA\Schema(
     *     schema="Items",
     *     type="object",
     *     title="Items",
     *     description="Items of shiporder",
     *     properties={  
     *         @OA\Property(property="title", type="string"), 
     *         @OA\Property(property="note", type="string"),
     *         @OA\Property(property="quantity", type="integer"),
     *         @OA\Property(property="price", type="float")
     *     }
     *  )
     */
    public function items()
    {
        return $this->hasMany('App\Models\Items', 'shiporder_id', 'id');
    }

    /**    
     *
     * @return void
     */
    public function person()
    {
        return $this->belongsTo('App\Models\People', 'person_id', 'id');
    }
}
