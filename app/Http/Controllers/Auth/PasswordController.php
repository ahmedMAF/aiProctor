<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    public function updateImage(Request $request){
        $user = $request->user();
        $oldImage = $user->profile_pic;
        $request->validate([
            'image' => ['nullable'],
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile_pics'), $imageName);

            if ($oldImage && file_exists(public_path('uploads/profile_pics/' . $oldImage))) {
                unlink(public_path('uploads/profile_pics/' . $oldImage));
            }
        } else {
            $imageName = $oldImage;
        }

        $user->update(['profile_pic' => $imageName]);
        
        return redirect('/profile');
    }
}
