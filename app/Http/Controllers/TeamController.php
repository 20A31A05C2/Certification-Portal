<?php

namespace App\Http\Controllers;

use App\Models\Usercertification;
use App\Models\VerificationTeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    //
    public function showTeamlogin(){
        return view('team.login');
    }

    public function Teamlogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);
    
        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('teams')->attempt($credentials)) {
            // Authentication successful
            $request->session()->regenerate();
            return redirect()->route('show.dashboard');
        }
    
        // Authentication failed
        return redirect()->back()->with('error', 'Invalid Email or Password');
    }
    

    // public function showteamdashboard(Request $request) {
    //     $currentUser = Auth::guard('teams')->user();
        
    //     // Get assigned certifications for the current team member
    //     $teamMember = VerificationTeamMember::where('email', $currentUser->email)->first();
    //     $assignedCertifications = [];
        
    //     if ($teamMember && $teamMember->assigned_certifications) {
    //         $assignedCertifications = json_decode($teamMember->assigned_certifications, true) ?? [];
    //     }
        
    //     // Base query
    //     $query = Usercertification::query();
        
    //     // Filter by assigned certifications
    //     if (!empty($assignedCertifications) && is_array($assignedCertifications)) {
    //         $query->whereIn('name', $assignedCertifications);
    //     }

    //     // Counts
    //     $totalSubmissions = (clone $query)->count();
    //     $pendingCount = (clone $query)->where('status', 'Pending')->count();
    //     $verifiedCount = (clone $query)->where('status', 'Verified')->count();
    //     $rejectedCount = (clone $query)->where('status', 'Rejected')->count();
        
    //     return view('team.teamdashboard', compact(
    //         'totalSubmissions',
    //         'pendingCount',
    //         'verifiedCount',
    //         'rejectedCount',
    //         'assignedCertifications'
    //     ));
    // }




    public function showteamdashboard(Request $request)
    {
       $currentUser = Auth::guard('teams')->user();
       $teamMember = VerificationTeamMember::where('email', $currentUser->email)->first();
       
       // Get user mappings
       $userMapping = Usercertification::whereIn('id', $teamMember->assigned_users)
                         ->pluck('userid', 'id')
                         ->toArray();
    
       $query = Usercertification::query();
       
       // Filter by assigned users
       if (!empty($userMapping)) {
           $query->whereIn('userid', array_values($userMapping));
       }
    
       // Get assigned certifications
       $assignedCertifications = []; 
       if ($teamMember && $teamMember->assigned_certifications) {
           $assignedCertifications = json_decode($teamMember->assigned_certifications, true) ?? [];
           if (!empty($assignedCertifications)) {
               $query->whereIn('name', $assignedCertifications);
           }
       }
    
       $totalSubmissions = (clone $query)->count();
       $pendingCount = (clone $query)->where('status', 'Pending')->count();
       $verifiedCount = (clone $query)->where('status', 'Verified')->count();
       $rejectedCount = (clone $query)->where('status', 'Rejected')->count();
    
       return view('team.teamdashboard', compact(
           'totalSubmissions',
           'pendingCount', 
           'verifiedCount',
           'rejectedCount',
           'assignedCertifications'
       ));
    }









    public function getCertificate($id)
    {
        try {
            $certification = Usercertification::findOrFail($id);
            
            $filePath = 'public/certifications/' . basename($certification->file);
            
            if (!Storage::exists($filePath)) {
                return response()->json(['error' => 'Certificate file not found'], 404);
            }
            
            return response()->file(Storage::path($filePath));
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }




    public function index(Request $request)
    {
       $member = auth()->user();
       
       // Get user IDs mapping
       $userMapping = Usercertification::whereIn('id', $member->assigned_users)
                         ->pluck('userid', 'id')
                         ->toArray();
       
       $query = Usercertification::query();
       
       \Log::info('Debug:', [
           'assigned_users' => $member->assigned_users,
           'user_mapping' => $userMapping,
           'certification_userids' => Usercertification::pluck('userid')->toArray()
       ]);
    
       $query->whereIn('userid', array_values($userMapping));
    
       if ($request->has('search')) {
           $query->where('userid', 'like', '%' . $request->search . '%');
       }
    
       if ($request->has('status') && $request->status !== 'all') {
           $query->where('status', $request->status);
       }
    
       $usercertifications = $query->paginate(10);
       return view('team.verifycertificates', compact('usercertifications')); 
    }




    public function verifyCertification($id)
    {
    $certification = UserCertification::findOrFail($id);
    
    $certification->status = 'Verified';
    $certification->save();

    return redirect()->back()->with('success', 'Certification verified successfully.');
    }

    public function rejectCertification($id)
    {
    $certification = UserCertification::findOrFail($id);
    
    $certification->status = 'Rejected';
    $certification->save();

    return redirect()->back()->with('error', 'Certification has been rejected.');
    }




    public function showteamprofile(){
        return view('team.teamprofile');
    }

    public function updateteamProfile(Request $request)
    {
        try {
            $user =  Auth::guard('teams')->user();
            
            if (!$user) {
                return back()->with('error', 'User not authenticated.');
            }

            $request->validate([
                'username' => 'required|string|max:255|unique:users,username,'.$user->id,
                'email' => 'required|email|unique:users,email,'.$user->id,
            ]);

            $user->username = $request->username;
            $user->email = $request->email;
            $user->update();

            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update profile. Please try again.')->withInput();
        }
    }


    public function updateteamPassword(Request $request)
    {
        try {
            $user =  Auth::guard('teams')->user();
            
            if (!$user) {
                return back()->with('error', 'User not authenticated.');
            }

            $request->validate([
                'current_password' => 'required|string',
                'new_password' => ['required', 'string', 'min:5', 'confirmed'],
                'new_password_confirmation' => 'required'
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect.');
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return back()->with('success', 'Password changed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update password. Please try again.');
        }
    }


    public function teamDelete(){
        try {
            $user =  Auth::guard('teams')->user();
            
            if (!$user) {
                return back()->with('error', 'User not authenticated.');
            }

            $user->delete();

            return redirect()->route('team.login')->with('success', 'Your account has been deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete account. Please try again.');
        }
    }

    public function teamlogout(){
        Auth::logout();
        return redirect()->route('team.login');
    }
    
}