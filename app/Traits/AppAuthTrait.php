<?php

namespace App\Traits;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

trait AppAuthTrait
{
    /**
     * User Logout
     *
     * @return void
     * @throws RuntimeException
     */
    public function logoutUser(): void
    {
        Auth::guard('web')->logout();

        // recommended
        try {
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        } catch (Exception $e) {
        }
    }

    /**
     * Get Login Validation Rules
     *
     * @return string[]
     */
    public function getLoginValidationRules()
    {
        return [
            'email'         => 'required|email',
            'password'      => 'required|min:2'
        ];
    }

    /**
     * Get Sign up request validation rules
     *
     * @return string[]
     */
    public function getSignupValidationRules()
    {
        return [
            'first_name'    => 'required|max:40',
            'last_name'     =>  'required|max:40',
            'email'         => 'required|unique:users,email',
            'password'      => 'required|min:2|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:2|same:password|required_with:password'
        ];
    }

    /**
     * Check if auth is authorized
     *
     * @param mixed $user
     * @return bool
     */
    public function authAttempt($user = null)
    {
        $user = $user ?? Auth::user();
        if (!$user) {
            return false;
        }

        $matchedUser = User::where('email', $user->email)->first();
        return $matchedUser && $matchedUser->is_active;
    }
}
