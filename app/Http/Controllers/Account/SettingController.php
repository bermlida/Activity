<?php

namespace App\Http\Controllers\Account;

use Auth;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FinancialAccount;

class SettingController extends Controller
{
    /**
     * 顯示帳戶設定編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['setting'] = Auth::user();
        
        return view('account.setting', $data);
    }

    /**
     * 回傳儲存帳戶設定時，請求資料的驗證結果。
     *
     * @return bool
     */
    protected function validator(array $data)
    {
        $rules = [
            'password' => 'sometimes|min:6|confirmed'
        ];

        return Validator::make($data, $rules);
    }

    /**
     * 儲存帳戶設定
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

        if ($request->has('password') && !empty($request->password)) {
            $account = Auth::user()->fill([
                'password' => bcrypt($request->input('password'))
            ]);

            if (!$account->save()) {
                $request->session()->flash('email', $account->email);
        
                $request->session()->flash('message_type', 'warning');

                $request->session()->flash('message_body', '儲存失敗');

                return view('account.setting');
            }
        }
        
        return redirect()
            ->route('account::setting')
            ->with([
                'message_type' => 'success',
                'message_body' => '儲存成功'
            ]);
    }

    /**
     * 顯示收款設定編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function receipt()
    {
        $data['organizer'] = Auth::user()->profile;

        $data['financial_account'] = $data['organizer']->financial_account;

        $data['taiwan_bank_codes'] = app('TaiwanBankCode')->listBankCodeATM();
        // print '<pre>'; var_dump($data); exit;
        return view('account.receipt-setting', $data);
    }

    /**
     * 儲存收款設定
     *
     * @return \Illuminate\Http\Response
     */
    public function saveReceipt(Request $request)
    {
        $organizer = Auth::user()->profile;

        if (is_null($organizer->financial_account)) {
            $financial_account = new FinancialAccount($request->all());

            $result = $organizer->financial_account()->save($financial_account);
        } else {
            $result = $organizer->financial_account->fill($request->all())->save();
        }
        
        return redirect()
            ->route('account::receipt-setting')
            ->with([
                'message_type' => $result ? 'success' : 'warning',
                'message_body' => $result ? '儲存成功' : '儲存失敗'
            ]);
    }
}
