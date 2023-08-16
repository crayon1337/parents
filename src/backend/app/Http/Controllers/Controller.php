<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Parents API Documentation",
 *      description="The API hosted by services will be documented below.",
 *      @OA\Contact(
 *          email="mohammedarey2@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Nginx 1.17.10",
 *          url="https://www.nginx.com"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Parents API Server"
 * )
 *
 * @OA\Tag(
 *     name="Users",
 *     description="API Endpoints of Users"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
}
