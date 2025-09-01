<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        if (Auth::check()) {
            // Menggunakan relasi baru: userNotifications()
            Auth::user()->userNotifications()->whereNull('read_at')->update(['read_at' => now()]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }
}