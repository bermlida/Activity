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
        
        return view('account.info', $data);
    }

    /**
     * 回傳儲存帳戶基本資料時，請求資料的驗證結果。
     *
     * @return bool
     */
    protected function validator(array $data)
    {
        $account = Auth::user();

        switch ($account->role_id) {
            case 1:
                $rules = [
                    'name' => 'required|string|max:128',
                    'mobile_phone' => 'sometimes|string|max:30'
                ];
                break;
            case 2:
                $rules = [
                    'name' => 'required|string|max:255',
                    'address' => 'required|string|max:512',
                    'phone' => 'required|string|max:30',
                    'fax' => 'sometimes|string|max:30',
                    'mobile_phone' => 'sometimes|string|max:30',
                    'intro' => 'required|string',
                    'photo' => 'sometimes|image|mimes:jpeg,bmp,png,gif,svg|dimensions:width=750,height=450'
                ];
                break;
            default:
                break;
        }
        
        return Validator::make($data, $rules);
    }

    /**
     * 儲存帳戶基本資料
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
                if (Auth::user()->role_id == 2) {
                    $this->storeBanner($profile, $request);
                }

                return redirect('/account/info')->with([
                    'message_type' => 'success',
                    'message_body' => '儲存成功'
                ]);
            }
        }

        $request->session()->flash('message_type', 'warning');

        $request->session()->flash('message_body', '儲存失敗');

        return view('account.info');
    }

    /**
     * 儲存主辦單位宣傳圖片
     *
     * @return \Illuminate\Http\Response
     */
    protected function storeBanner(Organizer $organizer, $request)
    {
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $stored_path = public_path('storage/banners/');
            $stored_filename = 'organizer-' . $organizer->id . '.' . $file->getClientOriginalExtension();

            $data = [
                'name' => $stored_filename,
                'type' => $file->getMimeType(),
                'size' => $file->getClientSize(),
                'path' => $stored_path . $stored_filename,
                'category' => 'banner',
                'description' => ''
            ];
            
            if ($organizer->attachments()->where('category', 'banner')->count() > 0) {
                $attachment = $organizer->attachments()
                    ->where('category', 'banner')
                    ->first();

                $attachment->update($data);
            } else {
                $organizer->attachments()->create($data);
            }

            $file->move($stored_path, $stored_filename);

            return true;
        }

        return !$request->hasFile('photo');
    }
}
