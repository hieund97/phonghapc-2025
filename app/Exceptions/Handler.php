<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        SlugRedirectException::class,
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable                $exception
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('*.html*')) {
            if ($exception instanceof NotFoundHttpException) {
                $variable = $request->fullUrl();
                $variable = substr($variable, 0, strpos($variable, ".html") + 5);
                return redirect()->to($variable);
            }
        }
        if ($exception instanceof SlugRedirectException) {
            return response()->json([
                'redirect_to' => $exception->getMessage(),
            ]);
        }

        if ($request->is('api/*')) {
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'message' => $exception->getMessage(),
                    'errors' => $exception->errors(),
                ], 500);
            }

            if ($exception instanceof ModelNotFoundException) {
                abort(404);
            }

            return $this->prepareJsonResponse($request, $exception);
        }

        return parent::render($request, $exception);
    }
}
