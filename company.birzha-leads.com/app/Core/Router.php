<?php
namespace App\Core;

use App\Controllers\AuthController;
use App\Controllers\IndexController;
use App\Utils\Exceptions\NotAuthorizedException;
use ReflectionException;

class Router
{
   private static array $routes = [];
   private static array $middlewares = [];

   private function __construct() {}
   private function __clone() {}

   public static function route($pattern, $callback, string $middleware = null): void
   {
       $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
       self::$routes[$pattern] = $callback;
       self::$middlewares[$pattern] = $middleware;
   }

    /**
     * @throws ReflectionException
     */
    public static function execute($url)
   {
       foreach (self::$routes as $pattern => $callback)
       {
           if (preg_match($pattern, strtok($url, '?'), $params))
           {
               array_shift($params);


               if (!empty(self::$middlewares[$pattern])) {
                   /** @var MiddlewareInterface $middleware */
                   $middleware = Dispatcher::dispatch(self::$middlewares[$pattern]);

                   try {
                       $middleware->run($callback);
                   } catch (NotAuthorizedException $notAuthorizedException) {

                       return call_user_func_array([
                           Dispatcher::dispatch(AuthController::class),
                           'notAuthorizedPage'
                       ], [$notAuthorizedException->getMessage()]);
                   }
               }

               $callback[0] = Dispatcher::dispatch($callback[0]);

               return call_user_func_array($callback, $params);
           }
       }
   }
}
