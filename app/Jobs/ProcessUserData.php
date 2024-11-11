<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessUserData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;  // Retry 3 times
    public $retryAfter = 60;  // Wait 60 seconds between retries

    /**
     * Create a new job instance.
     *
     * @param int $userId
     */
    public function __construct(protected $userId)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->userId);

        Log::channel('background_jobs')->info("Job started for user ID: {$user->id} at " . now());

        try {
            // Job running log
            Log::channel('background_jobs')->info("Processing user data for user ID: {$user->id} at " . now());

            // Simulate error (for demonstration purposes)
            if ($user->id === 1) {
                throw new Exception("Simulated error for user with ID 1");
            }

            // Job successful log
            Log::channel('background_jobs')->info("User data processed successfully for user ID: {$user->id} at " . now());

        } catch (Exception $e) {
            // Log error to background_jobs_errors.log
            Log::channel('background_jobs_errors')->error("Failed to process user ID: {$user->id} at " . now(), [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Final completion log
        Log::channel('background_jobs')->info("Job completed for user ID: {$user->id} at " . now());
    }
}
