<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Events\UserRegistered;
class AuthController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        if(request()->route()->uri == 'register' || request()->route()->uri == 'login')
            $this->middleware('guest');
    }
    
    public function login(Request $request)
    {
        //if the request is Get
        if($request->isMethod('get')){
            return view('auth.login');
        }

        //if the request is post validate the user
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Authentication passed...
            return redirect()->intended('/home');
        }

        return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
    }

    public function register(Request $request){

        //if the request is Get
        if($request->isMethod('get')){
            return view('auth.register');
        }

        //validate the input
        $this->validator($request->all())->validate();

        //register new user if validation is completed
        if($user = $this->create($request->all())){
            event(new UserRegistered($user));
            return redirect()->route('login')->with('success', 'Signed up Successfully');
        }
        return redirect()->back()->withErrors(['error'=> 'There was some problem creating account']);
    }

    protected function validator(array $data)
    {
        Validator::extend('strong_password', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $value);
        });

        Validator::replacer('strong_password', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.');
        });

       return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'strong_password'],
            'agree_term' => ['accepted']
        ],
        [
            'agree_term.accepted' => 'You must agree to the terms.'
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/home');
    }
}
