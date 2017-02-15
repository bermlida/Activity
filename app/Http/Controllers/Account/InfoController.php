<?php

namespace App\Http\Controllers\Account;

use Auth;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Organizer;
use App\Models\User;

class InfoController extends Controller
{
    /**
     * 顯示帳戶資訊及基本資料編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['info'] = Auth::user();
        
        $data['profile'] = $data['info']->profile ?? (object)[];
        
        return view('account.info', $data);
    }

    /**
     * 回傳儲存帳戶及基本資料時，請求資料的驗證結果。
     *
     * @return bool
     */
    protected function validator(array $data)
    {
        $account_rule = [
            'password' => 'sometimes|min:6|confirmed',
            'info_id' => 'required|numeric|exists:accounts,id',
            'role_id' => 'required|numeric|exists:accounts'
        ];

        if (isset($data['role_id'])) {
            switch ($data['role_id']) {
                case 1:
                    $profile_rule = [
                        'name' => 'required|string|max:128',
                        'mobile_phone' => 'sometimes|string|max:30'
                    ];
                    break;
                case 2:
                    $profile_rule = [
                        'name' => 'required|string|max:255',
                        'address' => 'required|string|max:512',
                        'phone' => 'required|string|max:30',
                        'fax' => 'sometimes|string|max:30',
                        'mobile_phone' => 'sometimes|string|max:30',
                        'intro' => 'required|string'
                    ];
                    break;
                default:
                    break;
            }
        }

        $profile_rule = $profile_rule ?? [];
        return Validator::make($data, array_merge($account_rule, $profile_rule));
    }

    /**
     * 儲存帳戶資訊及基本資料
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $info = Account::find($request->info_id);
        if ($request->has('password') && !empty($request->password)) {
            $info->password = bcrypt($request->password);
        }

        switch ($request->role_id) {
            case 1:
                $profile = $request->has('profile_id')
                            ? User::find($request->profile_id)->fill($request->all())
                            : new User($request->all());
                break;
            case 2:
                $profile = $request->has('profile_id')
                            ? Organizer::find($request->profile_id)->fill($request->all())
                            : new Organizer($request->all());
                break;
            default: break;
        }

        $info_result = $info->save();
        $profile_result = $profile->save();
        if (is_null($info->profile)) {
            $related_result = $profile->account()->save($info);
        } else {
            $related_result = true;
        }

        $data['info'] = $info;
        $data['profile'] = $profile;
        $data['save_result']['result'] = $info_result && $profile_result && $related_result;
        $data['save_result']['message'] = $data['save_result']['result']
            ? '儲存成功'
            : '儲存失敗';
        
        return view('account.info', $data);
    }
}
