<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // Matches "Member Management" + "View Member Profile" admin screens
    public function index()
    {
        return response()->json(['stub' => 'member list', 'members' => User::where('role', 'member')->get()]);
    }

    public function show(User $member)
    {
        return response()->json(['stub' => 'view member profile', 'member' => $member]);
    }

    // NOTE: per the Krisdel discussion, this should only expose status
    // (active/suspended), not a full profile form, members edit their
    // own name/email through Member\ProfileController instead.
    public function edit(User $member)
    {
        return response()->json(['stub' => 'manage member status form', 'member' => $member]);
    }

    public function update(Request $request, User $member)
    {
        return response()->json(['stub' => 'member status updated']);
    }
}
