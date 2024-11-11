<?php

use App\JobRunner;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Log;

function runBackgroundJob($className, $method, $parameters = [])
{
    // Instantiate the JobRunner class
    $jobRunner = new JobRunner();

    // Ensure the class is allowed and exists
    if (!class_exists($className) || !method_exists($className, $method) || !$jobRunner->isAllowedClass($className)) {
        Log::error("Unauthorized or undefined job class or method: $className::$method");
        return;
    }

    try {
        // Dispatch the job to run in the background with specified parameters
        Queue::push(new $className(...$parameters));
        Log::info("Dispatched job: $className::$method with parameters " . json_encode($parameters));
    } catch (\Exception $e) {
        Log::error("Failed to dispatch job: $className::$method", ['error' => $e->getMessage()]);
    }
}
