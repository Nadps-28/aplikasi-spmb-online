<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            $model->auditLog('created');
        });

        static::updated(function ($model) {
            $model->auditLog('updated');
        });

        static::deleted(function ($model) {
            $model->auditLog('deleted');
        });
    }

    public function auditLog($action)
    {
        $user = Auth::user();
        
        AuditLog::create([
            'user_id' => $user ? $user->id : null,
            'action' => $action,
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'old_values' => $action === 'updated' ? $this->getOriginal() : null,
            'new_values' => $action !== 'deleted' ? $this->getAttributes() : null,
            'ip_address' => request()->ip()
        ]);
    }

    public function customAuditLog($action, $description = null)
    {
        $user = Auth::user();
        
        AuditLog::create([
            'user_id' => $user ? $user->id : null,
            'action' => $action,
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'old_values' => null,
            'new_values' => ['description' => $description, 'timestamp' => now()],
            'ip_address' => request()->ip()
        ]);
    }
}