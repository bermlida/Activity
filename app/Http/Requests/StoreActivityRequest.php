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
        $before_start_time = $this->has('start_time') ? '|before:' . $this->input('start_time') : '';
        $before_end_time = $this->has('end_time') ? '|before:' . $this->input('end_time') : '';
        $before_apply_end_time = $this->has('apply_end_time')
         ? '|before:' . $this->input('apply_end_time')
         : '';

        return [
            'name' => 'required|string|max:255',
            'start_time' => 'required|date' . $before_end_time,
            'end_time' => 'required|date',
            'venue' => 'required|string|max:512',
            'venue_intro' => 'sometimes|string|max:255',
            'summary' => 'required|string|max:255',
            'apply_start_time' => 'required|date' . $before_apply_end_time . $before_start_time,
            'apply_end_time' => 'required|date' . $before_start_time,
            'can_sponsored' => 'required|integer|between:0,1',
            'is_free' => 'required|integer|between:0,1',
            'apply_fee' => 'required_if:is_free,0|integer|min:1',
            'intro' => 'required|string',
            'photo' => 'sometimes|image|mimes:jpeg,bmp,png,gif,svg|dimensions:width=1050,height=450',
            'status' => 'required|integer'
        ];
    }
}
