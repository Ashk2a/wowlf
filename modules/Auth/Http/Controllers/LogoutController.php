<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Http\Controllers\AbstractController;

class LogoutController extends AbstractController
{
    /**
     * @return RedirectResponse
     */
    public function get(): RedirectResponse
    {
        Auth::logout();

        $this->flashNowInfo(trans('toast.info.goodbye'));

        return redirect()->route('home');
    }
}