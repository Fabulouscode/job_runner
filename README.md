# Job Runner with Background Job Dispatching in Laravel

This project implements a background job dispatching system in Laravel using the Queue and Job mechanisms, with proper logging and error handling. It allows you to run background jobs asynchronously, track job status, handle errors, and retry jobs when necessary.

## Features

- **Background Job Dispatching**: Dispatch jobs asynchronously in the background.
- **Custom Logging**: Logs job statuses (e.g., running, completed, failed) into a custom log file (`background_jobs.log`).
- **Error Handling**: Logs errors from the background jobs into a separate log file (`background_jobs_errors.log`).
- **Retry Mechanism**: Configurable retry mechanism for failed jobs.
- **Job Execution**: Jobs are executed without blocking the main process, ensuring non-blocking operations.

## Installation

1. **Clone the Repository**

   Clone this repository to your local machine:

   ```bash
   git clone https://github.com/yourusername/job-runner.git
   cd job-runner

2. **Install Dependencies**

```bash
composer install

## Usage

This application includes a route to initiate a background job for processing user data. You can use this route to test background job execution.

### Initiate Background Job

To start a background job for processing user data, visit the `/test-job` endpoint.

Example route definition:

```php
Route::get('/test-job', function () {
    runBackgroundJob(\App\Jobs\ProcessUserData::class, 'handle', [1]);

    return 'Background job has been initiated';
});
