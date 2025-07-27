<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminPasswordResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        return $user && ($user->isSuperAdmin() || $user->isSchoolAdmin());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Please select a user.',
            'user_id.exists' => 'Selected user does not exist.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $user = auth()->user();
            $targetUserId = $this->input('user_id');
            
            if ($targetUserId) {
                $targetUser = \App\Models\User::find($targetUserId);
                
                if ($targetUser) {
                    // Check if school admin is trying to reset super admin password
                    if ($user->isSchoolAdmin() && $targetUser->isSuperAdmin()) {
                        $validator->errors()->add('user_id', 'You cannot reset a super admin password.');
                    }
                    
                    // Check if school admin is trying to reset password for user from different school
                    if ($user->isSchoolAdmin() && $targetUser->school_id !== $user->school_id) {
                        $validator->errors()->add('user_id', 'You can only reset passwords for users in your school.');
                    }
                }
            }
        });
    }
}