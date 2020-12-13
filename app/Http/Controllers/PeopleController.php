<?php

namespace App\Http\Controllers;

use App\Models\People;


class PeopleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/people",
     *     summary="Get all people",    
     *     security={ { "bearer_token": {} } }, 
     *     tags={"People"},     
     *     @OA\Response(
     *         response=200,
     *         description="People", 
     *         @OA\MediaType(    
     *              mediaType="application/json", 
     *              @OA\Schema(
     *                  schema="People",
     *                  type="array",
     *                  title="People",
     *                  description="People",
     *                  @OA\Items(ref="#/components/schemas/Person")
     *              )
     *         )
     *     ))
     * )
     * 
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
     *     security={ { "bearer_token": {} } },  
     *     tags={"People"},     
     *     @OA\Parameter(
     *         name="id",
     *         in= "path",
     *         description= "Person ID",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="People", 
     *         @OA\MediaType(    
     *              mediaType="application/json", 
     *              @OA\Schema(
     *                  schema="Person",
     *                  type="object",
     *                  title="Person",
     *                  description="Person",
     *                  properties={  
     *                      @OA\Property(property="person", ref="#/components/schemas/Person")
     *                  }
     *              )
     *         )
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
