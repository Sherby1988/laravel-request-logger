<?php

namespace Prettus\RequestLogger\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;

class implements ShouldQueue
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * Create a new job instance.
     *
     * @param  Request  $request
     * @param  Response $response
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $requestLogger = app(\Prettus\RequestLogger\ResponseLogger::class);
        $requestLogger->log($this->request, $this->response);
    }
}
