<?php

namespace App\Http\Controllers\Auth;

use DB;
use Socialite;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrganizerRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Account;
use App\Models\Organizer;
use App\Models\User;

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
        $result = DB::transaction(function () {
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
     * 重導使用者到社群認證頁面。
     *
     * @return Response
     */
    public function redirectToProvider($social_provider)
    {
        return Socialite::driver($social_provider)->redirect();
    }

    /**
     * 從社群認證提供者取得使用者資訊
     *
     * @return Response
     */
    public function handleProviderCallback($social_provider, Request $request)
    {
        $user = Socialite::driver($social_provider)->user();

        if (Account::where('email', $user->getEmail())->count() == 0) {
            $profile = User::create([
                'name' => $user->getName(),
                'mobile_country_calling_code' => '',
                'mobile_phone' => ''
            ]);

            $result = $profile->account()->save(
                (new Account)->forceFill([
                    'email' => $user->getEmail(),
                    'password' => bcrypt('1234567890'),
                    'role_id' => 1
                ])
            );
        } else {
            $result = true;
        }

        if ($result) {
            $account = Account::where('email', $user->getEmail())->first();

            return '
                <form style="display:none" id="__form" method="POST" action="' . url('/login') . '">
                    ' . csrf_field() . '
                    <input name="email" value="' . $account->email . '">
                    <input name="password" value="1234567890">
                    <input name="remeber">
                </form>
                <script type="text/javascript">
                    document.getElementById("__form").submit();
                </script>
            ';
        }
    }
}
