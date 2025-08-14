<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function accountRequestView()
    {
        $users = User::where('status', 'submitted')->get();
        $residents = Resident::where('user_id', null)->get();

        return view('pages.account-request.index', [
            'users' => $users,
            'residents' => $residents
        ]);
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'resident_id' => ['nullable', 'exists:residents,id'],
        ]);

        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();

        $residentId = $request->input('resident_id');

        if ($request->has('resident_id') && isset($residentId)) {
            Resident::where('id', $residentId)->update(['user_id' => $user->id
            ]);
        }

        return redirect()->route('account.request')->with('success', 'Permintaan akun telah disetujui.');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected';
        $user->save();

        return redirect()->route('account.request')->with('success', 'Permintaan akun telah ditolak.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('pages.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    public function editPassword()
    {
        return view('pages.profile.change-password');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'confirmed'],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Password berhasil diubah!');
    }
}
