<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    //
    public function register(){
        return view('register');
    }

    public function registerForm(Request $request)
    {
        $request->validate([
            'userid' => 'required|unique:users,userid|max:15',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
            'batchyear' => 'required|string',
            'branch' => 'required|string',
            'specialization' => 'required|string',
        ]);
    
        $user = User::create([
            'userid' => $request->userid,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'batchyear' => $request->batchyear,
            'branch' => $request->branch,
            'specialization' => $request->specialization,
        ]);
    
        return redirect()->route('login')->with('success', 'Registration Successful');
    }

//     public function showmain(Request $request)
// {
//     $stats = DB::table('certifications')
//         ->select('certifications.name')
//         ->selectRaw('COUNT(usercertifications.id) as count')
//         ->leftJoin('usercertifications', 'certifications.name', '=', 'usercertifications.name')
//         ->groupBy('certifications.name')
//         ->get();

//     if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
//         return response()->json([
//             'certifications' => $stats
//         ]);
//     }

//     return view('welcome');
// }







public function showmain(Request $request) {
    $stats = DB::table('users')
        ->join('usercertifications', 'users.userid', '=', 'usercertifications.userid')
        ->select('users.batchyear', 'usercertifications.organization')
        ->selectRaw('COUNT(usercertifications.id) as count')
        ->whereNotNull('users.batchyear')
        ->whereNotNull('usercertifications.organization')
        ->groupBy('users.batchyear', 'usercertifications.organization')
        ->orderBy('users.batchyear')
        ->orderBy('usercertifications.organization')
        ->get();

    if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
        return response()->json([
            'certifications' => $stats->map(function($item) {
                return [
                    'batch' => $item->batchyear,
                    'organization' => $item->organization,
                    'count' => $item->count
                ];
            })
        ]);
    }

    return view('welcome');
}



}
