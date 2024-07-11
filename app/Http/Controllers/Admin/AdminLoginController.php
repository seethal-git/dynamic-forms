<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class AdminLoginController extends Controller
{
    /**
     * Display the login form for the admin.
     *
     * This function returns the view for the admin login page.
     * @return \Illuminate\View\View The view for the admin login page.
     * 
     * @author Seethal Prasad
     */
    public function showLogin()
    {
        return view('admin.login');
    }
     /**
     * Handle the login request.
     * 
     * Validates the login credentials, attempts to authenticate the user,
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @author Seethal Prasad
     */
    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Prepare the credentials array for authentication attempt
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        // Attempt to authenticate the user with the given credentials
        if (Auth::guard('web')->attempt($credentials)) {
            // Retrieve the authenticated user
            $user = Auth::guard('web')->user();
            // Check if the user has the 'admin' role
            if ($user->role !== 'admin') {
                // Logout the user if they do not have the 'admin' role
                Auth::guard('web')->logout();
                return back()->withErrors(['error' => 'Invalid credentials or insufficient privileges.']);
            }
            // Store the user's email in the session
            $email = Auth::guard('web')->user()->email;
            Session::put('email',$email);   
            // Redirect to the intended URL (default is 'dashboard')
            return redirect()->intended('dashboard'); // Redirect to dashboard
        }
        else{
             // Redirect back with an error message if authentication fails
            return redirect()->back()->with('error', 'Invalid login credentials');
        }
    }
     /**
     * Display the dashboard for the admin.
     *
     * This function returns the view for the admin dashboard.
     * @return \Illuminate\View\View The view for the admin dashboard.
     * 
     * @author Seethal Prasad
     */
    public function showAdminDashboard()
    {
        return view('admin.dashboard');
    }
     /**
     * Handle the user logout process.
     *
     * This method logs out the authenticated user, flushes the session data,
     * regenerates the session, and then redirects the user to the login page.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the login page.
     * 
     * @author Seethal Prasad
     */
    public function logout(Request $request)
    {
        // Log out the authenticated user from the web guard
        Auth::guard('web')->logout();
        // Flush all session data
        $request->session()->flush();
        // Regenerate the session ID to avoid session fixation
        $request->session()->regenerate();
        return redirect('login');
    }
}
