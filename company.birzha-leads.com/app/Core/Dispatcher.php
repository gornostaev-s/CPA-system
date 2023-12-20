<?php

namespace App\Core;

use ReflectionException;
use ReflectionMethod;
use ReflectionClass;
use Throwable;

class Dispatcher
{
    /**
     * @throws ReflectionException
     */
    public function dispatchMethod1($method, $params = [])
    {
        $params = $this->uriParams;

        $funcData = new ReflectionMethod($this, $method);
        $parameters = $funcData->getParameters();
        $dependencies = [];

        $paramNames = array_keys($params);
        $paramValues = array_values($params);

        $i = 0;

        foreach ($parameters as $parameter) {
            $dependenceClass = $parameter->getType()->getName();

            try {
                if (new $dependenceClass() instanceof object) {
                    $findModel = !empty($paramNames[$i]) ?
                        $dependenceClass::findOne([$paramNames[$i] => $paramValues[$i]]) :
                        new $dependenceClass();

                    if (empty($findModel)) {
                        $this->raise404();
                        return false;
                    }

                    $dependencies[] = $findModel;
                } else {
                    $dependencies[] = new $dependenceClass();
                }
            } catch (Throwable $exception) {
                $dependencies[] = $paramValues[$i];
            }

            $i++;
        }
        return call_user_func_array([$this, $method], $dependencies);
    }

    /**
     * @throws ReflectionException
     */
    public static function dispatch($class)
    {
        if (!empty(App::app()->getService($class))) {
            return App::app()->getService($class);
        }

        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        return $constructor ?
            $reflection->newInstanceArgs(self::dispatchMethod($constructor)) :
            $reflection->newInstanceWithoutConstructor();
    }

    /**
     * @throws ReflectionException
     */
    public static function dispatchMethod(ReflectionMethod $method): array
    {
        $params = $method->getParameters();

        $res = [];
        foreach ($params as $param) {
            $res[] = self::dispatch($param->getType()->getName());
        }

        return $res;
    }
}