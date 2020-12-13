<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     summary="get token",        
     *     tags={"Login"},     
     *     @OA\RequestBody(
     *         required=true,     
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="password", type="string"),
     *              )
     *         ),
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="password", type="string"),
     *              )
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
     *                      @OA\Property(property="user", ref="#/components/schemas/User"),
     *                      @OA\Property(property="token", type="string")
     *                  }
     *              )
     *         )
     *     )
     * )
     * 
     * @return Shiporders
     */
    function index(Request $request)
    { 
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {            
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }
        
        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
