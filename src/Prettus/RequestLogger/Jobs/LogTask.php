<?php

namespace Prettus\RequestLogger\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;

class LogTask implements ShouldQueue
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
     * @var User
     */
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param  Request  $request
     * @param  Response $response
     */
    public function __construct($request, $response, $user)
    {
        $this->request = $request;
        $this->response = $response;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $requestLogger = app(\Prettus\RequestLogger\ResponseLogger::class);
        $requestLogger->log($this->request, $this->response, $this->user);
    }
}
