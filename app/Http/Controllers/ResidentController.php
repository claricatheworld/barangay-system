<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\OnlineId;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResidentController extends Controller
{
    /**
     * Show the resident dashboard.
     */
    public function dashboard()
    {
        $unread = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->where('title', '!=', 'Account Approved')
            ->count();

        $user = auth()->user();

        // Get active announcements (not expired and is_active = true)
        $announcements = Announcement::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('resident.portal-dashboard', compact('user', 'unread', 'announcements'));
    }

    /**
     * Show the resident's profile.
     */
    public function profile()
    {
        return view('resident.profile', ['user' => auth()->user()]);
    }

    /**
     * Update the resident's profile.
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other',
            'marital_status' => 'nullable|in:single,married,divorced,widowed,separated',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::delete('public/photos/' . $user->profile_photo);
            }

            $filename = $request->file('profile_photo')->store('photos', 'public');
            $user->profile_photo = basename($filename);
        }

        $user->first_name = $validated['first_name'];
        $user->middle_name = $validated['middle_name'] ?? null;
        $user->surname = $validated['surname'];
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->birthdate = $request->birthdate;
        $user->gender = $request->gender;
        $user->marital_status = $request->marital_status;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the resident's online ID.
     */
    public function onlineId()
    {
        $onlineId = OnlineId::where('user_id', auth()->id())
            ->with('user')
            ->first();

        if (!$onlineId) {
            return redirect()->back()->with('error', 'No Online ID found for your account.');
        }

        return view('resident.online-id', compact('onlineId'));
    }

    /**
     * Update ID photo.
     */
    public function updateIdPhoto(Request $request)
    {
        $validated = $request->validate([
            'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::delete('public/photos/' . $user->profile_photo);
            }

            // Store new photo
            $filename = $request->file('profile_photo')->store('photos', 'public');
            $user->profile_photo = basename($filename);
            $user->save();
        }

        return redirect()->back()->with('success', 'ID photo updated successfully.');
    }

    /**
     * Display resident's notifications.
     */
    public function notifications(Request $request)
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->where('title', '!=', 'Account Approved')
            ->latest()
            ->paginate(10);

        $unread = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->where('title', '!=', 'Account Approved')
            ->count();

        return view('resident.notifications', compact('notifications', 'unread'));
    }

    /**
     * Mark a notification as read.
     */
    public function markRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->is_read = true;
        $notification->save();

        return response()->json(['success' => true]);
    }
}
