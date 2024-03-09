<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //

    public function index(){
        return view('auth.login');
    }
    
    protected function login_process(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password,
            'is_active' => 1
        ];



            if(Auth::attempt($data)){
                return redirect()->route('home');
            }else{
                Auth::logout();
                return back()->with([
                    'account_deactivated' => 'Your account is deactivated! Please contact with Super Admin.'
                ]);
                // return redirect()->route('login')->with('failed','email or password is incorrect');
            }
        // }

    }

    public function logout(){
            Auth::logout();
            return redirect()->route('login')->with('succes','You have successfully logged out');
    }

    public function register()
    {
        return view('auth.register');
    }

    protected function register_process(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama'  => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);


        // User::create($data);
        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => 1
           ]);
        $login = [
            'email'     => $request->email,
            'password'  => $request->password
        ];

        if (Auth::attempt($login)) {
            return redirect()->route('home');
        } 
    }

    public function passwordReset()
    {
        return view('auth.PasswordReset');
    }

    public function forgot_password_act(Request $request)
    {
        $customMessage = [
                'email.required'    => 'Email tidak boleh kosong',
                'email.email'       => 'Email tidak valid',
                'email.exists'      => 'Email tidak terdaftar di database',
                'password.required' => 'Password tidak boleh kosong',
                'password.min'      => 'Password minimal 6 karakter',
                'password.confirmed' => 'Password tidak sesuai'
            ];
            
        $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:6|confirmed'
        ], $customMessage);
                
        $token = \Str::random(60);
        
        PasswordResetToken::updateOrCreate(
        [
            'email' => $request->email
        ],
        [
            'token' => $token,
            'email' => $request->email,
            'created_at' => now(),
        ]);
                            
                            
        $token = PasswordResetToken::where('email', $request->email)->value('token');
        if (!$token) {
            return redirect()->route('login')->with('failed', 'Token tidak valid');
        }
        
        $email = $request->email;
            $user = User::where('email', $request->email)->first();
            
                if (!$user) {
                        return redirect()->route('login')->with('failed', 'Email tidak terdaftar di database');
                    }
                
                
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        
        //     // $token->delete();
        
            return redirect()->route('login')->with('success', 'Password berhasil direset');                    
        // }
    }


}
