<?php


namespace App\Traits;


use App\Models\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasLogs
{
    public static function bootHasLogs()
    {
        static::created(function ($model) {
            static::writeLog($model->id, 'created');
        });

        static::saved(function ($model) {
            if (!$model->wasRecentlyCreated) {
                $diff = [];
                $origin = $model->getOriginal();

                foreach ($model->toArray() as $key => $value) {
                    if (!isset($origin[$key]) || is_array($value) || is_array($origin[$key])) {
                        continue;
                    }

                    if ($origin[$key] != $value) {
                        $diff[$key] = [
                            'from' => $origin[$key],
                            'to' => $value,
                        ];
                    }
                }

                unset($diff['real_images'], $diff['created_at'], $diff['updated_at']);

                if (!empty($diff)) {
                    static::writeLog($model->id, 'updated', $diff);
                }
            }
        });
    }

    public static function writeLog(int $loggableId, string $action, array $content = [])
    {
        $log = new Log;
        $log->user_id = Auth::user()->id ?? null;
        $log->action = $action;
        $log->loggable_type = static::class;
        $log->loggable_id = $loggableId;
        $log->loggable_content = $content;
        $log->save();
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }
}
