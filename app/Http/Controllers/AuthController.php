<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }


    /**
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            abort(404);
        }

        $credentials = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials, $request->remember_me ?? false)) {

            if ($request->ajax()) {
                return [
                    'status' => 1,
                    'message' => 'Success',
                    'redirectUrl' => route('home'),
                ];
            }

            return redirect()->route('home');
        }

        if ($request->ajax()) {
            return [
                'status' => 0,
                'message' => 'Wrong email or password PLZ try again',
            ];
        }

        return redirect()->back()->with('error', 'Wrong email or password PLZ try again');


    }


    /**
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($request->ajax()) {
            return [
                'status' => 1,
                'redirectUrl' => route('login'),
            ];
        }

        return redirect()->route('login');
    }


}
