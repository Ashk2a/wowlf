<?php

namespace App\Http\Controllers\Auth;

use App\Abstractions\Http\Controllers\BaseController;
use App\Contracts\Hashing\WotlkHasher;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Auth\Account;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends BaseController
{
    /**
     * @return Factory|View|Application
     */
    public function get(): Factory|View|Application
    {
        return view('pages.auth.register');
    }

    /**
     * @param RegisterRequest $request
     * @param WotlkHasher $wotlkHasher
     * @return RedirectResponse
     */
    public function post(RegisterRequest $request, WotlkHasher $wotlkHasher): RedirectResponse
    {
        $email = Str::lower($request->get('email'));
        $username = Str::upper($request->get('username'));

        [$salt, $verifier] = $wotlkHasher->make($username, $request->get('password'));

        $account = new Account();

        $account
            ->fill([
                'username' => $username,
                'email' => $email,
                'reg_mail' => $email,
                'salt' => $salt,
                'verifier' => $verifier
            ])
            ->save();

        $user = new User();

        $user
            ->fill([
                'account_id' => $account->id,
                'nickname' => $request->get('nickname'),
                'email' => $email,
                'password' => Hash::make($request->get('password'))
            ])
            ->save();

        // TODO: send event to trigger email

        toast()
            ->success(
                trans('toast.success.verification_email_sent', ['email' => $email]),
                trans('toast.title.registration_succeed')
            )
            ->push();

        return redirect()->route('auth.login');
    }
}
