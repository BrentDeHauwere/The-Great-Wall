<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreMessageRequest extends Request
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
          'user_id' => 'required|exists:users,id',
          'wall_id' => 'required|exists:walls,id',
          'channel_id' => 'required|exists:channels,id',
          'text' => 'required|string',
          'anonymous' => 'required|boolean',
          'question_id' => 'exists:messages,id',
          'moderator_id' => 'exists:users,id',
        ];
    }
}
