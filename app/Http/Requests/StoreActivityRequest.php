<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreActivityRequest extends Request
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
            'name' => 'required|string|max:255',
            'start_time' => 'required|date|before:end_time',
            'end_time' => 'required|date',
            'venue' => 'required|string|max:512',
            'venue_intro' => 'sometimes|string|max:255',
            'summary' => 'required|string|max:255',
            'apply_start_time' => 'required|date|before:apply_end_time|before:start_time',
            'apply_end_time' => 'required|date|before:start_time',
            'can_sponsored' => 'required|integer|between:0,1',
            'is_free' => 'required|integer|between:0,1',
            'apply_fee' => 'required_if:is_free,0|integer|min:1',
            'intro' => 'required|string',
            'photo' => 'sometimes|image|mimes:jpeg,bmp,png,gif,svg|dimensions:width=1050,height=450',
            'status' => 'required|integer'
        ];
    }
}
