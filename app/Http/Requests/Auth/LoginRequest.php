<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();
        $credentials = $this->only('email', 'password');
        $finduser = User::whereEmail($credentials['email'])->first();
        if (!is_null($finduser)) {
            if ($finduser->is_onserver) {
                $loginvalues = $this->only('password');
                $ldapconn = ldap_connect("remote.mse-europe.net");
                if ($ldapconn) {

                    try {
                        $ldapbind = ldap_bind($ldapconn, $finduser->username."@mse.local", $loginvalues['password']);
                        if ($ldapbind) {
                            Auth::login($finduser);
                        } else {
                            throw ValidationException::withMessages([
                                'email' => trans('auth.failed'),
                            ]);
                        }
                    } catch (\Exception $e)
                    {
                        throw ValidationException::withMessages([
                            'email' => trans('auth.failed'),
                        ]);
                    }


                }
            } else {
                if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
                    RateLimiter::hit($this->throttleKey());

                    throw ValidationException::withMessages([
                        'email' => trans('auth.failed'),
                    ]);
                }
            }
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')) . '|' . $this->ip();
    }
}
