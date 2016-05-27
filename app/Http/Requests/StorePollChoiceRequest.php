<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StorePollChoiceRequest extends Request
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
            'poll_id' => 'required|exists:polls,id',
            'text' => 'required|string',
            // 'moderator_id' => 'exists:users,id',
            'moderation_level' => 'integer',
        ];
    }
}
