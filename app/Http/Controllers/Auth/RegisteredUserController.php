<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,musician'],
            'instrument' => ['required_if:role,musician', 'string', 'max:255'],
            'about' => ['required_if:role,musician', 'string', 'max:1000'],
            'experience' => ['required_if:role,musician', 'string', 'max:1000'],
            'skills' => ['required_if:role,musician', 'string', 'max:1000'],
            'education' => ['required_if:role,musician', 'string', 'max:1000'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'instrument' => $request->role === 'musician' ? $request->instrument : null,
            'about' => $request->role === 'musician' ? $request->about : null,
            'experience' => $request->role === 'musician' ? $request->experience : null,
            'skills' => $request->role === 'musician' ? $request->skills : null,
            'education' => $request->role === 'musician' ? $request->education : null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
