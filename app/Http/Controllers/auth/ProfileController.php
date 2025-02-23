<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Certification;
use App\Models\Internship;
use App\Models\Usercertification;
use Illuminate\Support\Facades\Storage;
use App\Models\AppliedInternship;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function userdash()
    {
        // Get the currently logged in user
        $user = Auth::user();
        $userId = $user->userid;

        // Get certificates counts
        $totalCertificates = Usercertification::where('userid', $userId)->count();
        $pendingCertificates = Usercertification::where('userid', $userId)
            ->where('status', 'pending')
            ->count();
        $verifiedCertificates = Usercertification::where('userid', $userId)
            ->where('status', 'verified')
            ->count();
        $rejectedCertificates = Usercertification::where('userid', $userId)
            ->where('status', 'rejected')
            ->count();

        // Pass all data to the view
        return view('userdashboard', compact(
            'user',
            'totalCertificates',
            'pendingCertificates',
            'verifiedCertificates',
            'rejectedCertificates'
        ));
    }

    public function profile()
    {
        return view('userprofile');
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return back()->with('error', 'User not authenticated.');
            }

            // Validate all fields including academic details
            $request->validate([
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'email' => 'required|email|unique:users,email,' . $user->id,
                'batchyear' => 'required|string|max:20',
                'branch' => 'required|string|max:100',
                'specialization' => 'required|string|max:100'
            ]);

            // Update all user fields
            $user->username = $request->username;
            $user->email = $request->email;
            $user->batchyear = $request->batchyear;
            $user->branch = $request->branch;
            $user->specialization = $request->specialization;

            $user->update();

            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Profile update error: ' . $e->getMessage());

            return back()
                ->with('error', 'Failed to update profile. Please try again.')
                ->withInput();
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = Auth::user();

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
            $user = Auth::user();

            if (!$user) {
                return back()->with('error', 'User not authenticated.');
            }

            $user->delete();

            return redirect()->route('login')->with('success', 'Your account has been deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete account. Please try again.');
        }
    }


    public function addCertify()
    {
        $certifications = Certification::select('id', 'name', 'code', 'organization')->get();
        return view('addcertify', compact('certifications'));
    }

    public function Certificationstore(Request $request, $userid)
    {
        try {
            $loggedInUser = Auth::user();

            if (!$loggedInUser) {
                return back()->with('error', 'User not authenticated.');
            }

            // Debug information
            \Log::info('Form Data:', [
                'certification_id' => $request->certification_id,
                'organization' => $request->organization,
                'has_file' => $request->hasFile('certificate_file'),
                'route_userid' => $userid,
                'auth_userid' => $loggedInUser->userid
            ]);

            // Validate the request
            $request->validate([
                'certification_id' => 'required|exists:certifications,id',
                'organization' => 'required|string|max:255',
                'certificate_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            ]);

            try {
                // Get the certification details
                $certification = Certification::findOrFail($request->certification_id);

                // Handle file upload
                if ($request->hasFile('certificate_file')) {
                    $file = $request->file('certificate_file');
                    $fileName = time() . '_' . $loggedInUser->userid . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('certifications', $fileName, 'public');
                } else {
                    return back()->with('error', 'No file uploaded.');
                }

                // Create new certification record
                $userCertification = new Usercertification();
                $userCertification->userid = $loggedInUser->userid;
                $userCertification->name = $certification->name;
                $userCertification->organization = $request->organization;
                $userCertification->file = $filePath;
                $userCertification->status = 'Pending'; // Add default status if needed
                $userCertification->save();

                return redirect()->back()->with('success', 'Certification uploaded successfully!');
            } catch (\Exception $e) {
                \Log::error('Certification creation error: ' . $e->getMessage());

                // Clean up uploaded file if there was an error
                if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                return back()->with('error', 'Error uploading certification: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            \Log::error('Request processing error: ' . $e->getMessage());
            return back()->with('error', 'Error processing request: ' . $e->getMessage());
        }
    }


    public function viewsCertify(Request $request)
    {
        $status = Usercertification::select('status');
        $query = Usercertification::where('userid', Auth::user()->userid);

        // Handle search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $certifications = $query->orderBy('created_at', 'desc')
            ->paginate(10);


        $status = Usercertification::select('status')
            ->distinct()
            ->pluck('status');

        return view('viewcertify', compact('certifications', 'status'));
    }

    public function downloadCertificate($id)
    {
        try {
            $certification = Usercertification::where('userid', Auth::user()->userid)
                ->findOrFail($id);

            $filePath = storage_path('app/public/' . $certification->file);

            if (!file_exists($filePath)) {
                return back()->with('error', 'Certificate file not found.');
            }

            return response()->download($filePath);
        } catch (\Exception $e) {
            return back()->with('error', 'Error downloading certificate.');
        }
    }


    public function update(Request $request, $id)
    {
        $certification = Usercertification::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:2048'
        ]);

        // Handle file upload if a new file is provided
        if ($request->hasFile('file')) {
            // Delete old file from storage if it exists
            if ($certification->file) {
                Storage::disk('public')->delete($certification->file);
            }

            // Store new file in storage/public/certifications
            $filePath = $request->file('file')->store('certifications', 'public');

            // Update database with new file path
            $certification->file = $filePath;
        }

        // Update certification name
        $certification->name = $request->name;
        $certification->save();

        return redirect()->route('viewcertify')
            ->with('success', 'Certification updated successfully');
    }

    public function deleteCertify($id)
    {
        try {
            // Find the certification
            $certification = Usercertification::where('id', $id)->first();

            if (!$certification) {
                return back()->with('error', 'Certificate not found.');
            }

            // Delete the file if it exists
            if ($certification->file && Storage::disk('public')->exists($certification->file)) {
                Storage::disk('public')->delete($certification->file);
            }

            // Delete the certification record
            $certification->delete();

            return back()->with('success', 'Certificate deleted successfully.');
        } catch (\Exception $exception) {
            \Log::error('Certificate deletion error: ' . $exception->getMessage());
            return back()->with('error', 'Error deleting certificate. Please try again.');
        }
    }


    //internships
    public function AppIntern(Internship $internship) {
    // Get the userid from users table for current logged-in user
    $userUserId = auth()->user()->userid;

    // Check if already applied
    $exists = AppliedInternship::where('userid', $userUserId)
        ->where('name', $internship->name)
        ->exists();

    if($exists) {
        return back()->with('error', 'Already applied for this internship');
    }

    // Create new application with user's userid and end_date
    AppliedInternship::create([
        'userid' => $userUserId,
        'name' => $internship->name,
        'organization' => $internship->organization,
        'end_date' => $internship->end_date, // Add the end_date
        'status' => 'applied',

    ]);

    return back()->with('success', 'Successfully applied!');
    }
    
    public function userInternships(Request $request)
    {
    $search = $request->input('search');
    
    $internships = Internship::query()
        ->when($search, function($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('organization', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })
        ->latest()
        ->get();
    
    // Ensure we're using the correct user ID field
    $userId = auth()->user()->userid;
    
    $appliedInternships = AppliedInternship::where('userid', $userId)
        ->latest()
        ->get();
    
    return view('userinternships', compact('internships', 'appliedInternships'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
