<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->expectsJson()) {
            switch (get_class($exception)) {
                case \App\Exceptions\ModifySelfException::class:
                    return Response::json([
                        'error' => 'cannot_modify_self',
                    ], 400);
                case \App\Exceptions\InvalidExtensionException::class:
                    return Response::json([
                        'error' => 'invalid_extension',
                    ], 400);
                case \App\Exceptions\InvalidMimeTypeException::class:
                    return Response::json([
                        'error' => 'invalid_mimetype',
                    ], 400);
                case \App\Exceptions\InvalidUploadException::class:
                    return Response::json([
                        'error' => 'invalid_upload',
                    ], 400);
            }
        }
        return parent::render($request, $exception);
    }
}
