<?php
    namespace App\Http\Controllers;
    use App\Models\User;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rules\Password;
    class RegisterController extends Controller
    {
        /**
         * @return View
         */
        public function create(): View
        {
            return view('pages.auth.register');
        }
        /**
         * @param Request $request
         * @return RedirectResponse
         */
        public function store(Request $request): RedirectResponse
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:20',
                'email' => 'required|email|unique:users',
                'password' => Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers(),
                'password_confirm' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->route('auth.register.create')
                    ->withErrors($validator)
                    ->withInput();
            }
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            return redirect()->route('auth.login.create')
                ->with('success', 'Account created, please log in.');
        }
    }
