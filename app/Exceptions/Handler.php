<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];
    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) { // ¡VERIFICACIÓN CRUCIAL!
            if ($e instanceof AuthenticationException) {
                return response()->json(['message' => 'Token inválido o expirado.'], 401);
            }
            if ($e instanceof HttpException && $e->getStatusCode() == 401) {
                return response()->json(['message' => 'No autorizado.'], 401);
            }
            if ($e instanceof HttpException && $e->getStatusCode() == 403) {
                return response()->json(['message' => 'Prohibido.'], 403);
            }
            if ($e instanceof HttpException && $e->getStatusCode() == 404) {
                return response()->json(['message' => 'Recurso no encontrado.'], 404);
            }
            if ($e instanceof ValidationException) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            if (!($e instanceof HttpException)) {
                return response()->json(['message' => 'Error interno del servidor.'], 500);
            }
        }
        return parent::render($request, $e); // Manejo por defecto (HTML)
    }
}
