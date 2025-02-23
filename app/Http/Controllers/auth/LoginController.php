<?php

    namespace App\Http\Controllers\auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;


    class LoginController extends Controller
    {
        //
        public function login(){
            return view('login');
        }
        public function loginPost(Request $request)
    {
        // Validate the request
        $request->validate([
            'userid' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to log in using userid and password
        $credentials = [
            'userid' => $request->userid,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->route('dashboard')->with('success', 'Login successful.');
        }

        // Authentication failed
        return redirect()->back()->withErrors(['userid' => 'Invalid User ID or Password.'])
    ->withInput($request->except('password'));
    }


    public function Userforgot(){
        return view('forgot');
    }
        
    } 