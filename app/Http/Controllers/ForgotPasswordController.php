<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
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
            $expires = now()->addMinutes(60)->timestamp;
            $payload = Crypt::encryptString($user->id . '|' . $user->email . '|' . $expires);

            $resetUrl = URL::to('/reset-password?payload=' . urlencode($payload));

            Mail::to($user->email)->send(new ResetPasswordMail($user->name, $resetUrl));
        }

        return back()->with('status', 'Si el correo existe en nuestro sistema, recibirá un enlace para restablecer su contraseña.');
    }

    public function showResetForm(Request $request)
    {
        $data = $this->decryptPayload($request);

        if (!$data) {
            abort(403, 'El enlace de recuperación no es válido o ha expirado.');
        }

        return view('Auth.reset-password', [
            'email' => $data['email'],
            'id' => $data['user']->id,
            'payload' => $request->payload,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'payload' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $data = $this->decryptPayload($request);

        if (!$data) {
            abort(403, 'El enlace de recuperación no es válido o ha expirado.');
        }

        $data['user']->password = Hash::make($request->password);
        $data['user']->save();

        return redirect()->route('login')->with('success', 'Contraseña restablecida correctamente. Ahora puede iniciar sesión.');
    }

    private function decryptPayload(Request $request): ?array
    {
        try {
            $payload = $request->payload ?? $request->query('payload');
            if (!$payload) {
                return null;
            }

            $decrypted = Crypt::decryptString($payload);
            [$userId, $email, $expires] = explode('|', $decrypted, 3);

            if (now()->timestamp > (int) $expires) {
                return null;
            }

            $user = User::where('id', (int) $userId)
                ->where('email', $email)
                ->first();

            if (!$user) {
                return null;
            }

            return [
                'user' => $user,
                'email' => $email,
                'expires' => (int) $expires,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
