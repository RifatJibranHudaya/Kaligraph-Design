<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Log an action in the database.
     */
    public static function log(string $action, string $module, ?string $description = null, ?int $targetId = null): ActivityLog
    {
        $user = Auth::user();

        return ActivityLog::create([
            'user_id'     => $user ? $user->id : null,
            'username'    => $user ? $user->username : 'Guest/System',
            'action'      => $action,
            'module'      => $module,
            'target_id'   => $targetId,
            'description' => $description,
            'ip_address'  => Request::ip() ?? '0.0.0.0',
            'created_at'  => now(),
        ]);
    }
}
