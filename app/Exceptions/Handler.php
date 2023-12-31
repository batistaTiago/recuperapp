<?php

namespace App\Exceptions;

use DomainException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof AuthenticationException) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if ($e instanceof DomainException) {
            $httpStatus = ($e->getCode() !== 0) ? $e->getCode() : 400;
            $output = ['error' => $e->getMessage()];
            if (config('app.debug')) {
                $appTrace = $this->getAppTrace($e);

                $output['app_trace'] = $appTrace;
                $output['trace'] = $e->getTrace();
            }

            return response()->json($output, $httpStatus);
        }

        return parent::render($request, $e);
    }

    protected function shouldReturnJson($request, Throwable $e): bool
    {
        return true;
    }

    public function getAppTrace(Throwable $e): array
    {
        return collect($e->getTrace())->filter(function ($item) {
            return !array_key_exists('file', $item) || !strpos(($item['file']), 'vendor');
        })->values()->toArray();
    }
}
