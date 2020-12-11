<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * 
 * @package App\Http\Controllers
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Import XML API",
 *         @OA\License(name="MIT")
 *     ),
 *     @OA\Server(
 *         description="Server API Rest",
 *         url="http://localhost/api"
 *     ),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
