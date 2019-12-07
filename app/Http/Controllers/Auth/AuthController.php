<?php

namespace App\Http\Controllers\Auth;

use Auth;
use DB;
use Socialite;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreOrganizerRequest;
use App\Models\Account;
use App\Models\User;
use App\Models\Organizer;

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
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:128',
            'email' => 'required|email|max:255|unique:accounts',
            'password' => 'required|min:6|confirmed',
            'mobile_phone' => 'required|string|max:30'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $profile = User::create($data);

        $result = $profile->account()->save(
            (new Account)->forceFill([
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role_id' => 1
            ])
        );
        
        return $profile->account;
    }

    /**
     * 顯示會員註冊畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegisterUser()
    {
        return view('auth.register-user');
    }

    /**
     * 顯示主辦單位註冊畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegisterOrganizer()
    {
        return view('auth.register-organizer');
    }

    /**
     * 註冊會員。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerUser(StoreUserRequest $request)
    {
        $result = DB::transaction(function () use ($request) {
            $profile = User::create($request->all());

            $profile->account()->save(
                (new Account)->forceFill([
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'role_id' => 1
                ])
            );

            return !empty($profile->id) && !is_null($profile->account);
        });

        if (!$result) {
            return back()->withInput()->with([
                'message_type' => 'warning',
                'message_body' => '儲存失敗'
            ]);
        } else {
            return $this->login($request);
        }
    }

    /**
     * 註冊主辦單位。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerOrganizer(StoreOrganizerRequest $request)
    {
        $result = DB::transaction(function () use ($request) {
            $profile = Organizer::create($request->all());

            $profile->account()->save(
                (new Account)->forceFill([
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'role_id' => 2
                ])
            );

            return !empty($profile->id) && !is_null($profile->account);
        });

        if (!$result) {
            return back()->withInput()->with([
                'message_type' => 'warning',
                'message_body' => '儲存失敗'
            ]);
        } else {
            return $this->login($request);
        }
    }

    /**
     * 顯示以社群認證註冊會員或主辦單位的畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToRegister($social_provider)
    {
        return view('auth.register-user-or-organizer', ['social_provider' => $social_provider]);
    }

    /**
     * 因為註冊帳戶之需要，重導使用者到社群認證頁面。
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function askForRegister($social_provider, Request $request)
    {
        $redirect_url = url($request->path() . '/callback');
        
        return Socialite::driver($social_provider)
                    ->redirectUrl($redirect_url)
                    ->redirect();
    }

    /**
     * 因為帳戶登入之需要，重導使用者到社群認證頁面。
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function askForLogin($social_provider, Request $request)
    {
        $redirect_url = url($request->path() . '/callback');
        
        return Socialite::driver($social_provider)
                    ->redirectUrl($redirect_url)
                    ->redirect();
    }

    /**
     * 從社群認證提供者取得使用者資訊進行註冊
     *
     * @return Response
     */
    public function replyForRegister($social_provider, $role, Request $request)
    {
        $user = Socialite::driver($social_provider)
                    ->redirectUrl(url($request->path()))
                    ->user();

        if (Account::where('email', $user->getEmail())->count() == 0) {
            if ($role == 'user') {
                $profile = new User([
                    'name' => $user->getName(),
                    'mobile_country_calling_code' => '', 'mobile_phone' => ''
                ]);

                $role_id = 1;
            } elseif ($role == 'organizer') {
                $profile = new Organizer([
                    'name' => $user->getName(),
                    'address' => '',
                    'phone' => '', 'fax' => '',
                    'mobile_country_calling_code' => '', 'mobile_phone' => '',
                    'intro' => ''
                ]);

                $role_id = 2;
            }

            $result = DB::transaction(function () use ($user, $profile, $role_id) {
                $profile->save();

                $profile->account()->save(
                    (new Account)->forceFill([
                        'email' => $user->getEmail(),
                        'password' => bcrypt('1234567890'),
                        'role_id' => $role_id
                    ])
                );

                return !empty($profile->id) && !is_null($profile->account);
            });
        } else {
            $result = true;
        }

        if ($result) {
            $account = Account::where('email', $user->getEmail())->first();

            Auth::login($account);

            return redirect()->intended($this->redirectPath());
        } else {
            if ($role == 'user') {
                return redirect()->route('register::user');
            } elseif ($role == 'organizer') {
                return redirect()->route('register::organizer');
            } else {
                return redirect()->route('social-auth::register', ['social_provider' => $social_provider]);
            }
        }
    }

    /**
     * 從社群認證提供者取得使用者資訊進行登入
     *
     * @return Response
     */
    public function replyForLogin($social_provider, Request $request)
    {
        $user = Socialite::driver($social_provider)
                    ->redirectUrl(url($request->path()))
                    ->user();

        $account = Account::where('email', $user->getEmail())->first();

        if (!is_null($account)) {
            Auth::login($account);

            return redirect()->intended($this->redirectPath());
        } else {
            return redirect()->route('social-auth::register', ['social_provider' => $social_provider]);
        }
    }
}
