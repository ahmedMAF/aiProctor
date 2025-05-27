<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Exam;
use App\Models\UserExam;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        if($user->account_type){
            $exams = Exam::where("user_id" , $user->id)->get();
        }
        else{
            $exams = UserExam::with('exam')->where("user_id" , $user->id)->get();
        }
        return view('profile', [
            'user' => $user,
            'exams' => $exams,
        ]);
    }

    public function exams(Request $request): View
    {
        $user = $request->user();
        if($user->account_type){
            $exams = Exam::where("user_id" , $user->id)->get();
        }
        else{
            $exams = UserExam::with('exam')->where("user_id" , $user->id)->get();
        }
        return view('exams', [
            'user' => $user,
            'exams' => $exams,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
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
