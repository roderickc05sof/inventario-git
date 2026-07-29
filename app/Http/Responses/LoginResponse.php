<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): Response
    {
        // Si la petición espera JSON (peticiones API/Axios), responde correctamente
        if ($request->wantsJson()) {
            return new JsonResponse(['two_factor' => false], 200);
        }

        // Si es un inicio de sesión normal, redirige SIEMPRE a /assets
        return redirect()->intended('/assets');
    }
}