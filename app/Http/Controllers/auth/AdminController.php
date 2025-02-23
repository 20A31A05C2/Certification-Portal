<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Certification;
use App\Models\User;
use App\Models\Usercertification;
use App\Models\VerificationTeam;
use App\Models\VerificationTeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Internship;

class AdminController extends Controller
{
    //showregister
    public function showregister()
    {
        return view('admins.adminregister');
    }

    //register validation
    public function registerPost(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:admins,username|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:5|confirmed',
        ]);

        $admin = Admin::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('loginreg')->with('success', 'Registration Successful');
    }

    //show login
    public function showlogin()
    {
        return view('admins.adminlogin');
    }

    //login validation
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admins')->attempt($credentials)) {
            // Authentication successful
            $request->session()->regenerate();
            return redirect()->route('admindash');
        }

        // Authentication failed
        return redirect()->back()->with('error', 'Invalid Email or Password');
    }

    //fetch users to admin panel
    public function adminusers()
    {
        $users = User::all();
        return view('admins.adminusers', compact('users'));
    }




    public function getUserDetails(User $user)
    {
        // Get total certifications count
        $totalCertifications = DB::table('usercertifications')
            ->where('userid', $user->userid)
            ->count();

        // Get counts by status
        $pendingCount = DB::table('usercertifications')
            ->where('userid', $user->userid)
            ->where('status', 'pending')
            ->count();

        $verifiedCount = DB::table('usercertifications')
            ->where('userid', $user->userid)
            ->where('status', 'verified')
            ->count();

        $rejectedCount = DB::table('usercertifications')
            ->where('userid', $user->userid)
            ->where('status', 'rejected')
            ->count();

        $getcertificates = Usercertification::where('userid', $user->userid)->get();

        $certificationStats = [
            'pending' => $pendingCount,
            'verified' => $verifiedCount,
            'rejected' => $rejectedCount,

        ];

        return view('admins.userdetails', [
            'user' => $user,
            'totalCertifications' => $totalCertifications,
            'certificationStats' => $certificationStats,
            'getcertificates' => $getcertificates
        ]);
    }




    //delete users in adminpanel
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }

    //show adminprofile
    public function adminProfile()
    {
        return view('admins.adminprofile');
    }


    public function adminupdateProfile(Request $request)
    {
        try {
            $user = Auth::guard('admins')->user();

            if (!$user) {
                return back()->with('error', 'User not authenticated.');
            }

            $request->validate([
                'username' => 'required|string|max:255|unique:admins,username,' . $user->id,
                'email' => 'required|email|unique:admins,email,' . $user->id,
            ]);

            $user->username = $request->username;
            $user->email = $request->email;
            $user->update();

            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update profile. Please try again.')->withInput();
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = Auth::guard('admins')->user();

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

    public function deleteAccount(Request $request)
    {
        try {
            $user = Auth::guard('admins')->user();

            if (!$user) {
                return back()->with('error', 'User not authenticated.');
            }

            $user->delete();

            return redirect()->route('loginreg')->with('success', 'Your account has been deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete account. Please try again.');
        }
    }

    //show dashboard
    public function DashboardView()
    {
        return view('admins.admindashboard');
    }

    //show cerifiaction
    public function addCertification()
    {
        $certifications = Certification::all();
        $totalCertifications = $certifications->count();

        return view('admins.addcertification', compact('certifications', 'totalCertifications'));
    }

    //add certfications
    public function addCertificationPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'organization' => 'required|string',
        ]);
        $certification = Certification::create([
            'name' => $request->name,
            'code' => $request->code,
            'organization' => $request->organization,
        ]);
        return redirect()->route('addcert')->with('success', 'Added Sucessfully');
    }


    //     public function editcertification($id)
    // {
    //     $certification = Certification::findOrFail($id);
    //     return view('admin.certifications.edit', compact('certification'));
    // }


    public function addCertificationupdate(Request $request, $id)
    {
        try {
            $certification = Certification::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50',
                'organization' => 'required|string',
            ]);

            $certification->update($validated);

            // Ensure JSON response for AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Certification updated successfully!',
                ]);
            }


            return redirect()->back()->with('success', 'Certification updated successfully!')->compact('certifica');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function adminDestroy($id)
    {
        $certification = Certification::findOrFail($id);
        $certification->delete();

        return redirect()->back()->with('success', 'Certification deleted successfully');
    }

    //show team

    public function index()
    {
        $members = VerificationTeamMember::latest()->get();
        return view('admins.verifyteam', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|unique:verification_team_members',
            'password' => 'required|min:6',
            'certifications' => 'nullable|array',
            'assigned_users' => 'nullable|array'
        ]);

        $member = VerificationTeamMember::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'certifications' => $request->certifications ?? [],
            'assigned_users' => $request->assigned_users ?? []
        ]);

        return back()->with('success', 'Team member added successfully');
    }

    public function searchCertifications(Request $request) {
        $certifications = Certification::where('name', 'like', "%{$request->search}%")
            ->take(10)
            ->get(['id', 'name']);
            
        return response()->json($certifications);
    }
    
    public function searchUsers(Request $request) {
        $users = User::where('userid', 'like', "%{$request->search}%")
            ->take(10)
            ->get(['id', 'userid']);
            
        return response()->json($users);
    }
    

    public function delete($id)
    {   
        $deletemem = VerificationTeamMember::findOrFail($id);
        $deletemem->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }




    public function verifyedit($id)
    {
    $member = VerificationTeamMember::findOrFail($id);
    return view('admins.editverify', compact('member'));
    }

    public function update(Request $request, VerificationTeamMember $member)
{
    $validated = $request->validate([
        'username' => 'required|max:255',
        'email' => 'required|email|unique:verification_team_members,email,' . $member->id,
        'password' => 'required|min:6',
        'certifications' => 'nullable|array',
        'assigned_users' => 'nullable|array',
    ]);

    // Update basic information
    $member->username = $validated['username'];
    $member->email = $validated['email'];

    // Update password only if a new one is provided
    if (!empty($validated['password'])) {
        $member->password = Hash::make($validated['password']);
    }

    // Update certifications and assigned users
    $member->certifications = $request->certifications ?? [];
    $member->assigned_users = $request->assigned_users ?? [];

    $member->save();

    return redirect()->route('team.index')->with('success', 'Team member updated successfully');
}

   

    
    public function getCertificationStats(Request $request)
    {
        $timeRange = $request->input('timeRange', 'month');

        // Modified query to start from usercertifications table instead
        $query = DB::table('usercertifications')
            ->select('usercertifications.organization as name')
            ->selectRaw('COUNT(usercertifications.id) as count')
            ->whereNotNull('usercertifications.organization');  // Ensure we have organization

        // Apply time range filter to usercertifications
        switch ($timeRange) {
            case 'day':
                $query->whereDate('usercertifications.created_at', Carbon::today());
                break;

            case 'week':
                $query->whereBetween('usercertifications.created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;

            case 'month':
                $query->whereMonth('usercertifications.created_at', Carbon::now()->month)
                    ->whereYear('usercertifications.created_at', Carbon::now()->year);
                break;

            case 'quarter':
                $query->whereBetween('usercertifications.created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ]);
                break;

            case 'year':
                $query->whereYear('usercertifications.created_at', Carbon::now()->year);
                break;
        }

        // Group by organization
        $stats = $query->groupBy('usercertifications.organization')->get();

        // For debugging, you might want to see the query
        // dd($query->toSql(), $query->getBindings());

        $periodStart = $this->getPeriodStart($timeRange);
        $periodEnd = $this->getPeriodEnd($timeRange);

        return response()->json([
            'certifications' => $stats,
            'timeRange' => $timeRange,
            'periodStart' => $periodStart->format('Y-m-d'),
            'periodEnd' => $periodEnd->format('Y-m-d')
        ]);
    }

    private function getPeriodStart($timeRange)
    {
        switch ($timeRange) {
            case 'day':
                return Carbon::today();
            case 'week':
                return Carbon::now()->startOfWeek();
            case 'month':
                return Carbon::now()->startOfMonth();
            case 'quarter':
                return Carbon::now()->startOfQuarter();
            case 'year':
                return Carbon::now()->startOfYear();
            default:
                return Carbon::now()->startOfMonth();
        }
    }

    private function getPeriodEnd($timeRange)
    {
        switch ($timeRange) {
            case 'day':
                return Carbon::today()->endOfDay();
            case 'week':
                return Carbon::now()->endOfWeek();
            case 'month':
                return Carbon::now()->endOfMonth();
            case 'quarter':
                return Carbon::now()->endOfQuarter();
            case 'year':
                return Carbon::now()->endOfYear();
            default:
                return Carbon::now()->endOfMonth();
        }
    }

    public function uploadForm()
    {
        return view('admins.uploadform');
    }

    public function storeformdata(Request $request)
    {
        if ($request->has('certifications')) {
            $certifications = json_decode($request->certifications, true);

            foreach ($certifications as $cert) {
                Certification::create([
                    'name' => $cert['name'],
                    'code' => $cert['code'],
                    'organization' => $cert['organization']
                ]);
            }

            return response()->json(['success' => true]);
        }

        // Handle single certification creation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'organization' => 'required|string|max:255',
        ]);

        Certification::create($validated);

        return redirect()->back()->with('success', 'Certification added successfully');
    }

    public function viewMore($organization)
    {
        // Get all certificates for this organization
        $certificates = Certification::where('organization', $organization)
            ->select('id', 'name', 'code', 'created_at')
            ->get();

        // Get statistics for each certificate
        $certificateStats = [];
        foreach ($certificates as $certificate) {
            $certificateStats[$certificate->id] = [
                'batches' => DB::table('usercertifications as uc')
                    ->join('users as u', 'uc.userid', '=', 'u.userid')
                    ->where('uc.name', $certificate->name)
                    ->where('uc.organization', $organization)
                    ->select('u.batchyear', DB::raw('count(*) as count'))
                    ->groupBy('u.batchyear')
                    ->orderBy('u.batchyear')
                    ->get(),

                'branches' => DB::table('usercertifications as uc')
                    ->join('users as u', 'uc.userid', '=', 'u.userid')
                    ->where('uc.name', $certificate->name)
                    ->where('uc.organization', $organization)
                    ->select('u.branch', DB::raw('count(*) as count'))
                    ->groupBy('u.branch')
                    ->get(),

                'specializations' => DB::table('usercertifications as uc')
                    ->join('users as u', 'uc.userid', '=', 'u.userid')
                    ->where('uc.name', $certificate->name)
                    ->where('uc.organization', $organization)
                    ->select('u.specialization', DB::raw('count(*) as count'))
                    ->groupBy('u.specialization')
                    ->get(),

                'total' => UserCertification::where('name', $certificate->name)
                    ->where('organization', $organization)
                    ->count()
            ];
        }

        return view('admins.viewmore', compact(
            'organization',
            'certificates',
            'certificateStats'
        ));
    }


    public function certificateDetails(Request $request, $organization, $certName)
    {
        // Start building the query
        $query = DB::table('usercertifications as uc')
            ->join('users as u', 'uc.userid', '=', 'u.userid')
            ->where('uc.organization', $organization)
            ->where('uc.name', $certName);

        // Apply filters if they exist
        if ($request->filled('batch')) {
            $query->where('u.batchyear', $request->input('batch'));
        }
        if ($request->filled('branch')) {
            $query->where('u.branch', $request->input('branch'));
        }
        if ($request->filled('specialization')) {
            $query->where('u.specialization', $request->input('specialization'));
        }

        // Select fields
        $query->select(
            'u.userid',
            'u.username',
            'u.email',
            'u.batchyear',
            'u.branch',
            'u.specialization',
            'uc.status',
            'uc.file',
            'uc.created_at'
        );

        // Order by batch year and username
        $query->orderBy('u.batchyear', 'desc')
            ->orderBy('u.username');

        // Get paginated results
        $users = $query->paginate(10)->withQueryString();

        // Get filter options
        $filterOptions = [
            'batches' => DB::table('users as u')
                ->join('usercertifications as uc', 'u.userid', '=', 'uc.userid')
                ->where('uc.organization', $organization)
                ->where('uc.name', $certName)
                ->select('batchyear')
                ->distinct()
                ->whereNotNull('batchyear')
                ->orderBy('batchyear', 'desc')
                ->pluck('batchyear'),

            'branches' => DB::table('users as u')
                ->join('usercertifications as uc', 'u.userid', '=', 'uc.userid')
                ->where('uc.organization', $organization)
                ->where('uc.name', $certName)
                ->select('branch')
                ->distinct()
                ->whereNotNull('branch')
                ->orderBy('branch')
                ->pluck('branch'),

            'specializations' => DB::table('users as u')
                ->join('usercertifications as uc', 'u.userid', '=', 'uc.userid')
                ->where('uc.organization', $organization)
                ->where('uc.name', $certName)
                ->select('specialization')
                ->distinct()
                ->whereNotNull('specialization')
                ->orderBy('specialization')
                ->pluck('specialization')
        ];

        return view('admins.certificatedetails', compact(
            'organization',
            'certName',
            'users',
            'filterOptions'
        ));
    }


    public function Internship()
    {
        // Get all internships and count
        $internships = Internship::latest()->get();
        $totalInternships = Internship::count();
    
        // Return view with data
        return view('admins.internships', [
            'internships' => $internships,
            'totalInternships' => $totalInternships
        ]);
    }
    
    public function addInternship(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|url|max:255',
            'end_date' => 'required|date' // Added end date validation
        ]);
    
        Internship::create($validated);
    
        return redirect()->back()->with('success', 'Internship added successfully!');
    }



    public function interndestroy(Internship $internship)
    {
        $internship->delete();
        
        return redirect()->back()->with('success', 'Internship deleted successfully!');
    }



    //logout
    public function adminlogout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}
