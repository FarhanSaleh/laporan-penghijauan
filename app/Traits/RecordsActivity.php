<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        foreach (['created', 'updated', 'deleted'] as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }
    public function recordActivity($event)
    {
        ActivityLog::create([
            'user_id'      => Auth::id() ?? null, // Jika null berarti aksi sistem/guest
            'action'       => $event,
            'subject_type' => get_class($this), // Misal: App\Models\Product
            'subject_id'   => $this->id,
            'description'  => $this->getActivityDescription($event),
            'properties'   => $event === 'updated' ? $this->getChanges() : null, // Simpan perubahan jika update
        ]);
    }

    protected function getActivityDescription($event)
    {
        // Mengambil nama class saja (misal: "Product" dari "App\Models\Product")
        $modelName = class_basename($this);
        return "Melakukan {$event} pada {$modelName}";
    }
}
