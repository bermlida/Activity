<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreAccountInfoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (Auth::user()->role_id) {
            case 1:
                return $this->getRulesForUser();
            case 2:
                return $this->getRulesForOrganizer();
            default:
                return [];
        }
    }

    /**
     * 獲取適用於儲存用戶資訊的請求的驗證規則。
     *
     * @return array
     */
    protected function getRulesForUser()
    {
        return [
            'name' => 'required|string|max:128',
            'mobile_country_calling_code' => 'required|string|max:15',
            'mobile_phone' => 'required|string|max:30'
        ];
    }

    /**
     * 獲取適用於儲存主辦單位資訊的請求的驗證規則。
     *
     * @return array
     */
    protected function getRulesForOrganizer()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:512',
            'phone' => 'required|string|max:30',
            'fax' => 'sometimes|string|max:30',
            'mobile_country_calling_code' => 'required|string|max:15',
            'mobile_phone' => 'required|string|max:30',
            'intro' => 'required|string',
            'photo' => 'sometimes|image|mimes:jpeg,bmp,png,gif,svg|dimensions:width=750,height=450'
        ];
    }
}
