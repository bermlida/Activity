<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreActivityMessageRequest extends Request
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
        return [
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'sending_method' => 'required|array',
            'sending_target' => 'required|array',
            'sending_target.3' => 'sometimes|array',
            'join_schedule' => 'required|string|in:yes,no',
            'sending_time' => 'required_if:join_schedule,yes|date_format:"Y-m-d H:i"',
            'status' => 'required|integer'
        ];
    }
}
