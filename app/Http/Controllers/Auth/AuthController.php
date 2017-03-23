<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Role;
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
            'email' => 'required|email|max:255|unique:accounts',
            'password' => 'required|min:6|confirmed',
            'is_organizer' => 'required'
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
        $account = new Account([
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        
        if ($data['is_organizer'] == '1') {
            $account->role_id = 2;
        } else {
            $account->role_id = 1;
        }

        $account->save();
        
        return $account;
    }

    /**
     * 重導使用者到社群認證頁面。
     *
     * @return Response
     */
    public function redirectToProvider($social_provider)
    {
        session()->put('social_provider', $social_provider);

        return Socialite::driver($social_provider)->redirect();
    }

    /**
     * 從社群認證提供者取得使用者資訊
     *
     * @return Response
     */
    public function handleProviderCallback($social_provider)
    {
        $user = Socialite::driver($social_provider)->user();

        // OAuth Two 提供者
        // $token = $user->token;

        // OAuth One 提供者
        // $token = $user->token;
        // $tokenSecret = $user->tokenSecret;

        // 所有提供者
        print $user->getId(); print '<br>';
        print $user->getNickname(); print '<br>';
        print $user->getName(); print '<br>';
        print $user->getEmail(); print '<br>';
        print $user->getAvatar();
    }
}
