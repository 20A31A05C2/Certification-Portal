<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\ProfileController;
use App\Http\Controllers\auth\AdminController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;


Route::get('/', [RegisterController::class, 'showmain'])->name('stats');


//register routes
Route::get('register', [RegisterController::class, 'register']);
Route::post('register', [RegisterController::class, 'registerForm'])->name('register');


//login routes
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'loginPost'])->name('login.post');
Route::get('forgot', [LoginController::class, 'Userforgot'])->name('user.forgot');


//user dasboard all routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'userdash'])->name('dashboard');

    //userprofile
    Route::get('/userprofile', [ProfileController::class, 'profile'])->name('userprofile');
    Route::post('/userprofile', [ProfileController::class, 'updateProfile'])->name('userprofile');
    Route::post('/userpassword', [ProfileController::class, 'updatePassword'])->name('profile.password');

    //addingcertifications
    Route::get('/addcertify', [ProfileController::class, 'addCertify'])->name('addcertify');
    Route::post('/addcertify/{userid}', [ProfileController::class, 'Certificationstore'])->name('store.certify');

    //viewcertificates
    Route::get('/viewcertifications', [ProfileController::class, 'viewsCertify'])->name('viewcertify');
    Route::get('/viewcertifications/download/{id}', [ProfileController::class, 'downloadCertificate'])->name('download.certificate');
    Route::put('/certifications/{id}', [ProfileController::class, 'update'])->name('update.certificate');
    Route::delete('/viewcertifications/{id}', [ProfileController::class, 'deleteCertify'])->name('deleteview.certify');


    //avaliable internships
    Route::get('/internships', [ProfileController::class, 'userinternships'])->name('userintern');
    Route::post('/apply/{internship}', [ProfileController::class, 'AppIntern'])->name('apply.internship');




    //profile delete and logout
    Route::post('/userdelete', [ProfileController::class, 'deleteAccount'])->name('profile.delete');
    Route::get('/logout', [ProfileController::class, 'logout'])->name('logout');
});



//admins routes
Route::prefix('admin')->group(function () {

    //register
    Route::get('register', [AdminController::class, 'showregister'])->name('showreg');
    Route::post('register', [AdminController::class, 'registerPost'])->name('adminreg');

    //login
    Route::get('login', [AdminController::class, 'showlogin'])->name('loginreg');
    Route::post('login', [AdminController::class, 'loginPost'])->name('adlogin.post');

    Route::middleware('auth:admins')->group(function () {


        // Admin-only routes go here
        //admindashboard
        Route::get('dashboard', [AdminController::class, 'DashboardView'])->name('admindash');
        Route::get('dashboard/stats', [AdminController::class, 'getCertificationStats'])->name('certification.stats');

        Route::get('viewmore/{certName}', [AdminController::class, 'viewmore'])->name('viewmore');


        //users seen in adminpanel
        Route::get('/adminusers', [AdminController::class, 'adminusers'])->name('adminusers');
        Route::get('/admin/adminusers/{user}/details', [AdminController::class, 'getUserDetails'])->name('adminusers.details');
        Route::delete('/adminusers/{id}', [AdminController::class, 'destroy'])->name('adminusers.destroy');

        //adminprofile
        Route::get('/adminprofile', [AdminController::class, 'adminProfile'])->name('adminprofile');
        Route::post('/adminupdate', [AdminController::class, 'adminupdateProfile'])->name('adminupdate');
        Route::post('/adminpassword', [AdminController::class, 'updatePassword'])->name('adminpassword');
        Route::delete('/admindelete', [AdminController::class, 'deleteAccount'])->name('admindelete');


        //addcertification
        Route::get('/addcertification', [AdminController::class, 'addCertification'])->name('addcert');
        Route::post('/addcertification', [AdminController::class, 'addCertificationPost'])->name('addcertify.post');
        Route::put('/certifications/{id}', [AdminController::class, 'addCertificationupdate'])->name('update.certify');
        Route::delete('/certifications/{id}', [AdminController::class, 'adminDestroy'])->name('delete.certify');
        Route::get('/certifications/upload', [AdminController::class, 'uploadForm'])->name('certifications.upload');
        Route::post('/certifications/upload', [AdminController::class, 'storeformdata'])->name('uploadformdata');



        // Detailed certificate view with filters
        Route::get('/admin/certification/{organization}/{certName}', [AdminController::class, 'certificateDetails'])
            ->name('certification.details');


        //Interships routes in admin
        Route::get('/internships', [AdminController::class, 'Internship'])->name('intern');
        Route::post('/internships', [AdminController::class, 'addInternship'])->name('internships.store');
        Route::delete('/internships/{internship}', [AdminController::class, 'interndestroy'])->name('internships.destroy');

        


        //addverification team
        Route::get('/team', [AdminController::class, 'index'])->name('team.index');
        Route::post('/team', [AdminController::class, 'store'])->name('team.store');
        Route::get('/certifications/search', [AdminController::class, 'searchCertifications'])->name('certifications.search');
        Route::get('/users/search', [AdminController::class, 'searchUsers'])->name('users.search');
        Route::get('/team/{id}/edit', [AdminController::class, 'verifyedit'])->name('team.edit');
        Route::put('/admin/team/{member}', [AdminController::class, 'update'])->name('team.update');
        Route::delete('/delete/{id}', [AdminController::class, 'delete'])->name('teamdelete');
        
        
        //logout
        Route::get('/adminlogout', [AdminController::class, 'adminlogout'])->name('admin.logout');
    });
});



Route::prefix('team')->group(function () {
    //login
    Route::get('login', [TeamController::class, 'showTeamlogin'])->name('team.login');
    Route::post('login', [TeamController::class, 'Teamlogin'])->name('post.login');



    Route::middleware('auth:teams')->group(function () {
        //dashboard
        Route::get('dashboard', [TeamController::class, 'showteamdashboard'])->name('show.dashboard');

        //profile
        Route::get('profile', [TeamController::class, 'showteamprofile'])->name('show.profile');
        Route::post('updateprofile', [TeamController::class, 'updateteamProfile'])->name('updateteam.Profile');
        Route::post('updatepassword', [TeamController::class, 'updateteamPassword'])->name('updateteam.Password');
        Route::post('delete', [TeamController::class, 'teamDelete'])->name('team.delete');

  

        Route::get('/verify-certificates', 
        [TeamController::class, 'index'])
        ->name('verify.certify');

    // View individual certification
    Route::get('/certification/{id}', [TeamController::class, 'getCertificate'])
    ->name('certification.get');

    // Verify certification
    Route::post('/certification/{id}/verify', 
        [TeamController::class, 'verifyCertification'])
        ->name('user.verify');

    // Reject certification
    Route::post('/certification/{id}/reject', 
        [TeamController::class, 'rejectCertification'])
        ->name('user.reject');





        //logout
        Route::get('/logout', [TeamController::class, 'teamlogout'])->name('team.logout');
    });
});
