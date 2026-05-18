<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $categories = \App\Models\Category::withCount('products')->get();

        return view('profile', [
            'user' => $request->user(),
            'categories' => $categories,
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

        if ($request->hasFile('photo')) {

            if (
                $request->user()->photo &&
                Storage::disk('public')->exists($request->user()->photo)
            ) {
                Storage::disk('public')->delete($request->user()->photo);
            }

            $path = $request->file('photo')->store('profile', 'public');

            $request->user()->photo = $path;
        }

        $request->user()->save();

        return Redirect::route('profile')->with('status', 'profile-updated');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = auth()->user();

        if (
            $user->photo &&
            Storage::disk('public')->exists($user->photo)
        ) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('profile', 'public');

        $user->photo = $path;

        $user->save();

        return back();
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
