<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $totalOfficials = User::where('role', 'official')->count();

        $totalResidents = User::where('role', 'resident')->count();

        $pendingResidents = User::where('role', 'resident')
            ->where('status', 'pending')
            ->count();

        $recentOfficials = User::where('role', 'official')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalOfficials', 'totalResidents', 'pendingResidents', 'recentOfficials'));
    }

    /**
     * Display a listing of officials.
     */
    public function officials(Request $request)
    {
        $officials = User::where('role', 'official')
            ->latest()
            ->paginate(15);

        return view('admin.officials.index', compact('officials'));
    }

    /**
     * Show the form for creating a new official.
     */
    public function createOfficial()
    {
        return view('admin.officials.create');
    }

    /**
     * Store a newly created official in storage.
     */
    public function storeOfficial(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $plain = $request->password;

        $user = User::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'surname' => $validated['surname'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => 'official',
            'status' => 'approved',
        ]);

        $html = '<div style="font-family:Segoe UI,sans-serif;padding:32px;background:#f0f9ff"><div style="background:linear-gradient(135deg,#1a6fcc,#3a8a3f);padding:32px;text-align:center;border-radius:12px 12px 0 0"><p style="color:white;font-size:22px;font-weight:700;margin:0">🏛️ Barangay Management System</p><p style="color:rgba(255,255,255,0.8);margin:8px 0 0">Official Account Created</p></div><div style="background:white;padding:40px;border-radius:0 0 12px 12px"><p>Dear <strong>' . $user->getFullName() . '</strong>,</p><p>A Barangay Official account has been created for you.</p><div style="background:#daf0fa;border-radius:8px;padding:20px;margin:20px 0"><p style="margin:0"><strong>Email:</strong> ' . $user->email . '</p><p style="margin:8px 0 0"><strong>Password:</strong> <code>' . $plain . '</code></p></div><p style="color:#e65100;font-size:13px">⚠️ Please change your password after first login.</p><a href="' . url('/login') . '" style="background:#3a8a3f;color:white;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:700;display:inline-block;margin-top:16px">Log In Now</a></div></div>';

        MailService::send(
            $user->email,
            $user->getFullName(),
            'Your Barangay Official Account Has Been Created',
            $html
        );

        return redirect('/admin/officials')->with('success', 'Official account created and credentials emailed.');
    }

    /**
     * Delete the specified official.
     */
    public function deleteOfficial($id)
    {
        $official = User::where('id', $id)
            ->where('role', 'official')
            ->firstOrFail();

        $official->delete();

        return redirect()->back()->with('success', 'Official removed successfully.');
    }
}
