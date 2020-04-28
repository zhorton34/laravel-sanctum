<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSanctumToken extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->id()
        ]);
    }

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
        $sanctum = collect(config('sanctum.abilities'));
        $abilities = fn ($group, $ability) => is_array($group) ? array_keys($group) : [$ability];

        return [
            'token_name' => [
                'required',
                Rule::unique('personal_access_tokens', 'name')->where(
                    fn ($query) => $query->whereIn('id', auth()->user()->tokens->pluck('id')->toArray())
                )
            ],
            'ability.*' => [
                Rule::in($sanctum->flatMap($abilities)->toArray())
            ]
        ];
    }
}
