<?php
/**
 * Created by PhpStorm.
 * User: hzw
 * Date: 2017/5/17
 * Time: 10:26
 */

namespace App\Http\Middleware;

use Closure;

// !!!需要在Kernel.php中的$middleware数组、$routeMiddleware及$middlewareGroups['api']中注册
class Cors
{
    /**
     *
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        header("Access-Control-Allow-Origin: *");

        $headers = [
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
        ];

        $response = $next($request);
        foreach($headers as $key => $value)
            $response->header($key, $value);
        return $response;

        return $next($request);
    }

}
