<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateActivityRequest extends Request
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
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'venue' => 'required|string|max:512',
            'venue_intro' => 'sometimes|string|max:255',
            'apply_fee' => 'required|numeric',
            'summary' => 'required|string|max:255',
            'intro' => 'required|string',
            'status' => 'required|numeric'
        ];
    }
}
