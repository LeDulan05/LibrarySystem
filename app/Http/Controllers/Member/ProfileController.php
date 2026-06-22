<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // TODO: matches "My Profile" screen, member edits their own name/email here
    public function edit(Request $request)
    {
        return response()->json(['stub' => 'profile edit form', 'user' => $request->user()]);
    }

    public function update(Request $request)
    {
        return response()->json(['stub' => 'profile updated']);
    }
}
