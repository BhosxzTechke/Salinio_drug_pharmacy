<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    
use Spatie\Activitylog\Models\Activity;


class AuditController extends Controller
{
    //

public function AuditTrail(Request $request)
{
    $query = Activity::query();

    // Filter
    if ($request->user) {
        $query->whereHas('causer', fn($q) => 
            $q->where('name', 'like', '%' . $request->user . '%')
        );
    }

    if ($request->action) {
        $query->where('description', 'like', '%' . $request->action . '%');
    }

    // Exclude login and logout logs
    $query->whereNotIn('description', ['User logged in automatically', 'User logged out automatically']);

    $activities = $query->latest()->paginate(10);

    return view('Audit.audit', compact('activities'));
}




    public function AuditLog(Request $request)
    {
        $query = Activity::query();

        // Filter by user name
        $query->when($request->user, function ($q) use ($request) {
            $q->whereHas('causer', function ($subQ) use ($request) {
                $subQ->where('name', 'like', '%' . $request->user . '%');
            });
        });

        // Filter by action description
        $query->when($request->action, function ($q) use ($request) {
            $q->where('description', 'like', '%' . $request->action . '%');
        });

        // Only show authentication-related logs
        $activities = $query->where('log_name', 'auth')->latest()->paginate(10);

        return view('Audit.auditLog', compact('activities'));
    }


}
