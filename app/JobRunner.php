<?php

namespace App;

use Illuminate\Support\Facades\Log;

class JobRunner
{
    public static function run($className, $method, $parameters = [])
    {
        try {
            if (!self::isAllowedClass($className)) {
                throw new \Exception("Unauthorized class");
            }

            $instance = app($className);
            if (!method_exists($instance, $method)) {
                throw new \Exception("Method $method does not exist in $className");
            }

            $result = call_user_func_array([$instance, $method], $parameters);

            Log::info("Job executed: $className::$method", [
                'status' => 'success',
                'result' => $result,
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error("Job failed: $className::$method", [
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public static function isAllowedClass($className)
    {
        $allowedClasses = [
            // List allowed classes here
            \App\Jobs\ProcessUserData::class,
        ];

        return in_array($className, $allowedClasses);
    }
}
