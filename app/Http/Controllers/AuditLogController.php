<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\NotificationLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->orderBy('created_at', 'desc');
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $auditLogs = $query->paginate(50);
        
        return view('admin.audit-logs.index', compact('auditLogs'));
    }
    
    public function notifications(Request $request)
    {
        $query = NotificationLog::with('user')->orderBy('created_at', 'desc');
        
        if ($request->filled('channel')) {
            $query->where('channel', $request->channel);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $notificationLogs = $query->paginate(50);
        
        return view('admin.notification-logs.index', compact('notificationLogs'));
    }
}