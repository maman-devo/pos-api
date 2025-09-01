<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Menggunakan relasi baru: userNotifications()
            $unreadNotifications = $user->userNotifications()->whereNull('read_at')->latest()->get();
            $unreadNotificationsCount = $unreadNotifications->count();

            $view->with('unreadNotifications', $unreadNotifications);
            $view->with('unreadNotificationsCount', $unreadNotificationsCount);
        }
    }
}