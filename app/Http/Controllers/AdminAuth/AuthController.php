<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\AdminUser;
use Validator;
use Auth;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';
	protected $guard = 'admin';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
	public function showLoginForm()
    {
        return view('admin_auth.login');
    }
    public function login(Request $request)
    {

        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.

        $credentials = $this->getCredentials($request);

        if (Auth::guard('admin')->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

	protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);
    }

	protected function getCredentials(Request $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }

	protected function handleUserWasAuthenticated(Request $request)
    {
        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::guard('admin')->user());
        }
        return redirect('/admin');
    }

	protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'These credentials do not match our records.';
    }

	public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('/admin/login');
    }

}
