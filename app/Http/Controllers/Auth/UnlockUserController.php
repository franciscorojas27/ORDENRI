<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Notifications\UnlockAccountNotification;

class UnlockUserController extends Controller
{
    /**
     * Muestra la vista de desbloqueo por correo electrónico.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.unlock.unlock-email');
    }
    /**
     * Envía un enlace de desbloqueo al correo electrónico del usuario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendUnlockLink(Request $request)
    {
        $request->validate(['email' => 'required|exists:users,email']);
        $user = User::where('email', $request->email)->firstOrFail();
        if (!$user->is_blocked) {
            return back()->with('status', 'Tu cuenta no está bloqueada.');
        }
        // Crea la url firmada, esto es un método creado en el modelo user.
        $url = $user->getUnlockUrl();
        $user->notify(new UnlockAccountNotification($url));
        return back()->with('status', 'El enlace de desbloqueo ha sido enviado al correo electrónico proporcionado.');
    }
    /**
     * Desbloquea la cuenta del usuario utilizando un enlace firmado.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @param string $hash
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function unlockUser(Request $request, $id, $hash)
    {
        if (!URL::hasValidSignature($request)) {
            abort(403, 'El enlace no es válido o ha expirado.');
        }
        $user = User::findOrFail($id);
        if ($user->is_blocked == false) {
            return redirect()->route('login')
                ->withErrors(['userid' => trans('auth.unlock')]);
        }
        if (sha1($user->email) !== $hash) {
            abort(403, 'El hash no coincide.');
        }

        // Desbloquear al usuario
        $user->update(['is_blocked' => false]);

        return response()->json(['message' => 'Tu cuenta ha sido desbloqueada exitosamente.']);
    }
}
