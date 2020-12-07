<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Dashboard;
use App\LoginHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/dashboard/index";


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        //$this->login

        //$this->sendLoginResponse()
    }
    /*public function login(Request $request)
    {
        return view('dashboard.index');

    }*/

    // function login(Request $request) {

    //     $user = User::where("phone", $request->phone)
    //         ->where("password", $request->password)
    //         ->where('email', $request->email)
    //         ->where('username', $request->username)
    //         ->first();

    //     Auth::login($user);

    //     LoginHistory::create([
    //         'ip' => request()->ip(),
    //         'user_id' => Auth::user()->id,
    //         'phone_details' => ''//LoginHistory::getInfo(new Request())
    //     ]);

    //     return redirect()->route('dashboard.index');
    // }

    protected function authenticated(Request $request, $user)
    {
        // $user->update([
        //     'last_login_at' => Carbon::now()->toDateTimeString(),
        //     'last_login_ip' => $request->getClientIp()
        // ]);

        LoginHistory::create([
            'ip' => request()->ip(),
            'user_id' => Auth::user()->id,
            'phone_details' => LoginHistory::getInfo($request)
        ]);
    }





    /**
     * logout custom
     */
    protected function logout() {
        $redirectTo = Auth::user()->type == 'student'? route('studentLogin') : route('login');
        Auth::logout();
        return redirect($redirectTo);
    }

    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('email'))){
          return ['username' => $request->get('email'), 'password'=>$request->get('password'), 'active' =>1];
        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
          return ['email' => $request->get('email'), 'password'=>$request->get('password'), 'active' =>1];
        }
        elseif(is_numeric($request->get('email'))){
          return ['phone'=>$request->get('email'),'password'=>$request->get('password'), 'active' =>1];
        }
        return ['username' => $request->get('email'), 'password'=>$request->get('password'), 'active' =>1];
      }
}
