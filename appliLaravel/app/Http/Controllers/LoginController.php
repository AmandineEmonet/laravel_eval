<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * @return View
     */
    public function create(): View
    {
        return view('pages.auth.login');
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return redirect()
                ->route('auth.login.create')
                ->withErrors($validator)
                ->withInput();
        }
//pour rechercher un nom $user = User::where('name','Alizée')
        $user = User::where('email', $request->input('email'))->first();
        //$request premier paramètre mdp en clair duxième paramètres mdp hashé
        if ($user && Hash::check($request->input('password'), $user->password)) {
            auth()->login($user);
            return redirect()->route('posts.index')->with('success', 'logged in successfully');
        }
        return redirect()->route('auth.login.create')->with('error', 'wrong information');
    }
}
