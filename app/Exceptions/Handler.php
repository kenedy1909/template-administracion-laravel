<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $dontReport = [
        AuthenticationException::class,
        HttpException::class,
        HttpResponseException::class,
        ValidationException::class,
    ];


    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'estado' => 'error',
                    'message' => 'No autorizado',
                    'code' => 401
                ], 401);
            }
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Modelo no encontrado'], Response::HTTP_NOT_FOUND);
        }


        if ($exception instanceof AuthenticationException) {
            return response()->json(['error' => 'No autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json(['error' => 'Ruta no encontrada'], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['error' => 'Método no permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof HttpResponseException) {
            return $exception->getResponse();
        }

        return parent::render($request, $exception);
    }
}
