<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user",
     *     summary="Get all users",    
     *     security={ { "bearer_token": {} } }, 
     *     tags={"User"},     
     *     @OA\Response(
     *         response=200,
     *         description="User", 
     *         @OA\MediaType(    
     *              mediaType="application/json", 
     *              @OA\Schema(
     *                  schema="User",
     *                  type="array",
     *                  title="User",
     *                  description="User",
     *                  @OA\Items(ref="#/components/schemas/User")
     *              )
     *         )
     *     )
     * )
     * 
     * @return User
     */
    public function all(){
        return User::all();
    }

    /**
     * @OA\Get(
     *     path="/user/{id}",
     *     summary="Get user by id",    
     *     security={ { "bearer_token": {} } },  
     *     tags={"User"},     
     *     @OA\Parameter(
     *         name="id",
     *         in= "path",
     *         description= "User ID",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="User", 
     *         @OA\MediaType(    
     *              mediaType="application/json", 
     *              @OA\Schema(
     *                  schema="User",
     *                  type="object",
     *                  title="User",
     *                  description="User",
     *                  properties={  
     *                      @OA\Property(property="user", ref="#/components/schemas/User")
     *                  }
     *              )
     *         )
     *     )
     * )
     * 
     * @param int $id
     * @return User
     */
    public function show(int $id)
    {
        return User::findOrFail($id);
    }

     /**
     * @OA\Post(
     *     path="/user",
     *     summary="create user",        
     *     tags={"User"},     
     *     @OA\RequestBody(
     *         required=true,     
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/User")
     *         )
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="Token", 
     *         @OA\MediaType(    
     *              mediaType="application/json", 
     *              @OA\Schema(
     *                  schema="Token",
     *                  type="object",
     *                  title="Token",
     *                  description="User Token",
     *                  properties={  
     *                      @OA\Property(property="user", ref="#/components/schemas/User")
     *                  }
     *              )
     *         )
     *     )
     * )
     * 
     * @return Shiporders
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'email' => 'required|unique:users|max:200',
            'name' => 'required',
            'password' => 'required'
        ]);

        if($validator->passes()){
            return User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        }
        else{
            return ['errors' => $validator->errors()->all()];
        }
    }
}
