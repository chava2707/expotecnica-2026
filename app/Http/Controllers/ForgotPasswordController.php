<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('Auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $resetUrl = URL::temporarySignedRoute(
                'password.reset',
                now()->addMinutes(60),
                ['id' => $user->id, 'email' => $user->email]
            );

            Mail::to($user->email)->send(new ResetPasswordMail($user->name, $resetUrl));
        }

        return back()->with('status', 'Si el correo existe en nuestro sistema, recibirá un enlace para restablecer su contraseña.');
    }

    public function showResetForm(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'El enlace de recuperación no es válido o ha expirado.');
        }

        $user = User::where('id', $request->id)
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            abort(403, 'Usuario no encontrado.');
        }

        return view('Auth.reset-password', [
            'email' => $user->email,
            'id' => $user->id,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!$request->hasValidSignature()) {
            abort(403, 'El enlace de recuperación no es válido o ha expirado.');
        }

        $user = User::where('id', $request->id)
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            abort(403, 'Usuario no encontrado.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Contraseña restablecida correctamente. Ahora puede iniciar sesión.');
    }
}
