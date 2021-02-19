<?php

namespace App\Http\Controllers\Account;

use Auth;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountInfoRequest;
use App\Models\Account;
use App\Models\Organizer;
use App\Models\User;
use App\Services\FileUploadService;

class InfoController extends Controller
{
    /**
     * 顯示帳戶基本資料編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['account'] = Auth::user();

        $data['profile'] = $data['account']->profile;

        if (!is_null($data['profile']) && $data['account']->role_id == 2) {
            $data['banner'] = $data['profile']->attachments()->IsBanner()->first();
        }

        $data['country_calling_codes'] = config('constant.CountryCallingCodes');
        
        return view('account.info', $data);
    }

    /**
     * 儲存帳戶基本資料
     *
     * @return \Illuminate\Http\Response
     */
    public function save(StoreAccountInfoRequest $request)
    {
        $account = Auth::user();

        if (is_null($account->profile)) {
            switch ($account->role_id) {
                case 1:
                    $profile = new User($request->all());
                    break;
                case 2:
                    $profile = new Organizer($request->all());
                    break;
                default:
                    break;
            }
        } else {
            $profile = $account->profile->fill($request->all());
        }

        if ($profile->save()) {
            if (!is_null($account->profile) || $profile->account()->save($account)) {
                if ($account->role_id == 2) {
                    if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                        $photo = $request->file('photo');

                        app(FileUploadService::class)->uploadOrganizerBanner($photo, $profile);
                    }
                }

                return redirect()
                        ->route('account::info')
                        ->with([
                            'message_type' => 'success',
                            'message_body' => '儲存成功'
                        ]);
            }
        }

        return back()->withInput()->with([
                    'message_type' => 'warning',
                    'message_body' => '儲存失敗'
                ]);
    }
}
