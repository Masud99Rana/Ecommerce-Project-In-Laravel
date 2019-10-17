<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\RegistrationEmailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function processLogin()
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = request()->only(['email', 'password']);

        if (auth()->attempt($credentials)) {
            if (auth()->user()->email_verified_at === null) {
                $this->setError('Your account is not activated.');

                return redirect()->route('login');
            }

            $this->setSuccess('User logged in.');

            return redirect('/');
        }

        $this->setError('Invalid credentials.');

        return redirect()->back();
    }

    public function showRegisterForm()
    {
        return view('frontend.auth.register');
    }

    public function processRegister()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|min:11|max:13|unique:users,phone_number',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'name' => request()->input('name'),
                'email' => strtolower(request()->input('email')),
                'phone_number' => request()->input('phone_number'),
                'password' => bcrypt(request()->input('password')),
                'email_verification_token' => uniqid(time(), true).str_random(16),
            ]);

            

            $user->notify(new RegistrationEmailNotification($user));
            $this->setSuccess('Account registered');

            return redirect()->route('login');
        } catch (\Exception $e) {
            $this->setError($e->getMessage());

            return redirect()->back();
        }
    }

    public function activate($token = null)
    {
        if ($token === null) {
            return redirect('/');
        }

        $user = User::where('email_verification_token', $token)->firstOrFail();

        if ($user) {
            $user->update([
                'email_verified_at' => Carbon::now(),
                'email_verification_token' => null,
            ]);

            $this->setSuccess('Account activated. You can login now.');

            return redirect()->route('login');
        }

        $this->setError('Invalid token.');

        return redirect()->route('login');
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }

    public function profile()
    {
        $data = [];
        $data['orders'] = Order::where('user_id', auth()->user()->id)->get();

        return view('frontend.auth.profile', $data);
    }
}
