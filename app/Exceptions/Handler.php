<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
		if ($request->acceptsHtml() || $request->expectsJson() || $request->acceptsAnyContentType()) {

			if ($exception instanceof NotFoundHttpException)
				return response()->json([
					'success'	=> false,
					'error'		=> 'Incorrect route'
				], Response::HTTP_NOT_FOUND);

			if ($exception instanceof MethodNotAllowedHttpException)
				return response()->json([
					'success'	=> false,
					'error'		=> 'Method not allowed'
				], Response::HTTP_METHOD_NOT_ALLOWED);


		}

		return parent::render($request, $exception);
	}
}
