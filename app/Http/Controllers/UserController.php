<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function account_request_view()
    {
        $user = User::where('status', 'submitted')->get();
        return view('pages.account-request.index', [
            'users' => $user,
        ]);
    }

    public function account_approval(Request $request, $userId)
    {
        $for = $request->input('for');
        $user = User::findOrFail($userId);
        $user->status = $for == 'approve' ? 'approved' : 'rejected';
        $user->save();

        return back()->with('success', $for == 'approve' ? 'Berhasil menyetujui akun!' : 'Berhasil menolak akun!');
    }
}
