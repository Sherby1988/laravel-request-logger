<?php
namespace Prettus\RequestLogger\Middlewares;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Prettus\RequestLogger\Jobs\LogTask;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Closure;
use Route;

class ResponseLoggerMiddleware
{
    use DispatchesJobs;

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response)
    {

        if(!$this->excluded($request)) {
            $user = Auth::user();
            $task = new LogTask($request, $response, $user);

            if($queueName = config('request-logger.queue')) {
                $this->dispatch(is_string($queueName) ? $task->onQueue($queueName) : $task);
            } else {
                $task->handle();
            }
        }
    }

    protected function excluded(Request $request) {
        $exclude = config('request-logger.exclude');

        if($exclude){
            foreach($exclude as $path) {
                if($request->is($path)) return true;
            }
        }

        return false;
    }
}
