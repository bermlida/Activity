<?php

namespace App\Http\Controllers\Account;

use Auth;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountSettingRequest;
use App\Http\Requests\StoreFinancialAccountRequest;
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
     * 儲存帳戶設定
     *
     * @return \Illuminate\Http\Response
     */
    public function save(StoreAccountSettingRequest $request)
    {
        if ($request->has('password')) {
            $result = $account = Auth::user()->fill([
                'password' => bcrypt($request->input('password'))
            ])->save();
        } else {
            $result = true;
        }

        return redirect()
            ->route('account::setting')
            ->with([
                'message_type' => $result ? 'success' : 'warning',
                'message_body' => $result ? '儲存成功' : '儲存失敗'
            ]);
    }

    /**
     * 顯示收款設定編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function showReceiptSetting()
    {
        $data['organizer'] = Auth::user()->profile;

        $data['financial_account'] = $data['organizer']->financial_account;

        $data['taiwan_bank_codes'] = app('TaiwanBankCode')->listBankCodeATM();
        
        return view('account.receipt-setting', $data);
    }

    /**
     * 儲存收款設定
     *
     * @return \Illuminate\Http\Response
     */
    public function saveReceiptSetting(StoreFinancialAccountRequest $request)
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

    /**
     * 顯示退款設定編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function showRefundSetting()
    {
        $data['user'] = Auth::user()->profile;

        $data['financial_account'] = $data['user']->financial_account;

        $data['taiwan_bank_codes'] = app('TaiwanBankCode')->listBankCodeATM();
        
        return view('account.refund-setting', $data);
    }

    /**
     * 儲存退款設定
     *
     * @return \Illuminate\Http\Response
     */
    public function saveRefundSetting(StoreFinancialAccountRequest $request)
    {
        $user = Auth::user()->profile;

        if (is_null($user->financial_account)) {
            $financial_account = new FinancialAccount($request->all());

            $result = $user->financial_account()->save($financial_account);
        } else {
            $result = $user->financial_account->fill($request->all())->save();
        }
        
        return redirect()
            ->route('account::refund-setting')
            ->with([
                'message_type' => $result ? 'success' : 'warning',
                'message_body' => $result ? '儲存成功' : '儲存失敗'
            ]);
    }
}
