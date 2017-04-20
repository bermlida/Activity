<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrganizerRequest;
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
            'email' => 'required|email|max:255|unique:accounts',
            'password' => 'required|min:6|confirmed'
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
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function showApplyForm()
    {
        return view('auth.apply');
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apply(StoreOrganizerRequest $request)
    {
        $profile = Organizer::create($request->all());

        $result = $profile->account()->save(
            (new Account)->forceFill([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role_id' => 2
            ])
        );

        $this->login($request);

        return redirect($this->redirectPath());
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
            $profile = User::create(['name' => $user->getName(), 'mobile_phone' => '']);

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
