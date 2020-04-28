<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSanctumToken extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();

        return $user->tokens()->where('id', request('id'))->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $sanctum = collect(config('sanctum.abilities'));
        $abilities = fn ($group, $ability) => is_array($group) ? array_keys($group) : [$ability];

        return [
            'id' => 'required',
            'token_name' => 'required|string',
            'ability.*' => "in:" . $sanctum->flatMap($abilities)->implode(',')
        ];
    }
}
