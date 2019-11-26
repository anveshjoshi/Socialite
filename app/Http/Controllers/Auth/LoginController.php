<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGithubCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        //add user to db

        $user = User::where('provider_id', $githubUser->getId())->first();

        if (!$user) {
        $user = User::create([
            'name' => $githubUser->getNickName(),
            'email' => $githubUser->getEmail(),
            'provider_id' => $githubUser->getId(),
            'provider' => 'github',
        ]);
    }

        //remember me

        Auth::login($user, true);

        return redirect($this->redirectTo);
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        //add user to db

        $user = User::where('provider_id', $facebookUser->getId())->first();

        if (!$user) {
            $user = User::create([
                'name' => $facebookUser->getNickName(),
                'email' => $facebookUser->getEmail(),
                'provider_id' => $facebookUser->getId(),
                'provider' => 'facebook',
            ]);
        }

        //remember me

        Auth::login($user, true);

        return redirect($this->redirectTo);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        //add user to db

        $user = User::where('provider_id', $googleUser->getId())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'provider_id' => $googleUser->getId(),
                'provider' => 'google',
            ]);
        }

        //remember me

        Auth::login($user, true);

        return redirect($this->redirectTo);
    }
}
