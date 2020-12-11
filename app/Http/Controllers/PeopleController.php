<?php

namespace App\Http\Controllers;

use App\Models\People;


class PeopleController extends Controller
{
     /**
     * @OA\Get(
     *     path="/people",
     *     summary="Get all people",     
     *     tags={"People"},     
     *     @OA\Response(
     *         response=200,
     *         description="Person",     
     *         @OA\Schema(ref="#/components/schemas/PersonResponse", type="array"),     
     *     )
     * )
     * 
     * @param int $id
     * @return People
     */
    public function all()
    {
        return People::all();
    }

    /**
     * @OA\Get(
     *     path="/people/{id}",
     *     summary="Get person by id",     
     *     tags={"People"},     
     *      @OA\Parameter(
     *         name="id",
     *         in= "path",
     *         description= "Person ID",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Person",     
     *         @OA\Schema(ref="#/components/schemas/PersonResponse"),     
     *     )
     * )
     * 
     * @param int $id
     * @return People
     */
    public function show(int $id)
    {
        return People::findOrFail($id);
    }
}
