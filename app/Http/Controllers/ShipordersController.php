<?php

namespace App\Http\Controllers;

use App\Models\Shiporders;
use Illuminate\Http\Request;

class ShipordersController extends Controller
{
    /**
     * @OA\Get(
     *     path="/shiporders",
     *     summary="Get all shiporders", 
     *     security={ { "bearer_token": {} } },     
     *     tags={"ShipOrder"},     
     *     @OA\Response(
     *         response=200,
     *         description="Shiporders", 
     *         @OA\MediaType(    
     *              mediaType="application/json", 
     *              @OA\Schema(
     *                  schema="Shiporders",
     *                  type="array",
     *                  title="Shiporders",
     *                  description="Shiporder",
     *                  @OA\Items(ref="#/components/schemas/Shiporder")
     *              )
     *         )
     *     ))
     * )
     * 
     * @return Shiporders
     */
    public function all()
    {
        return Shiporders::all();
    }

    /**
     * @OA\Get(
     *     path="/shiporders/{id}",
     *     summary="Get shiporder by id",  
     *     security={ { "bearer_token": {} } },    
     *     tags={"ShipOrder"},     
     *      @OA\Parameter(
     *         name="id",
     *         in= "path",
     *         description= "ShipOrder ID",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Shiporders", 
     *         @OA\MediaType(    
     *              mediaType="application/json", 
     *              @OA\Schema(
     *                  schema="Shiporder",
     *                  type="object",
     *                  title="Shiporder",
     *                  description="Shiporder",
     *                  properties={  
     *                      @OA\Property(property="shiporder", ref="#/components/schemas/Shiporder")
     *                  }
     *              )
     *         )
     *     )
     * )
     * 
     * @param int $id
     * @return Shiporders
     */
    public function show(int $id)
    {
        return Shiporders::findOrFail($id);
    }
}
