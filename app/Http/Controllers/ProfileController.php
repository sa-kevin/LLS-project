<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'translations' => [
                'setting' => __('profileInfo.setting'),
                'delete' => __('delete.delete'),
                'text1' => __('delete.text1'),
                'delete_btn' => __('delete.delete_btn'),
                'form_delete' => __('delete.form_delete'),
                'form_text' => __('delete.form_text'),
                'cancel' => __('delete.cancel'),
                'update_pwd' => __('uploadPwd.update_pwd'),
                'text2' => __('uploadPwd.text2'),
                'current' => __('uploadPwd.current'),
                'new' => __('uploadPwd.new'),
                'confirm' => __('uploadPwd.confirm'),
                'save_btn' => __('uploadPwd.save_btn'),
                'saved' => __('uploadPwd.saved'),
                'profile_info' => __('profileInfo.profile_info'),
                'text3' => __('profileInfo.text3'),
                'name' => __('profileInfo.name'),
                'email' => __('profileInfo.email'),
                'verify' => __('profileInfo.verify'),
                'send_btn' => __('profileInfo.send_btn'),
                'link' => __('profileInfo.link'),
                'save' => __('profileInfo.save'),
                'saved2' => __('profileInfo.saved'),
            ],
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
