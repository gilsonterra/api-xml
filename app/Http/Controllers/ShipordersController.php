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
     *     tags={"ShipOrder"},     
     *     @OA\Response(
     *         response=200,
     *         description="ShipOrder",     
     *         @OA\Schema(ref="#/components/schemas/ShipOrder", type="array"),     
     *     )
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
     *         description="ShipOrder",     
     *         @OA\Schema(ref="#/components/schemas/ShipOrder"),     
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
