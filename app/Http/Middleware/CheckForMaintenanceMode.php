<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Option;

class CheckForMaintenanceMode
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
     */
    protected $except = [
        'ph_admin',
        'ph_admin/*',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->isMaintenanceMode() && !$this->isExcluded($request)) {
            return response(file_get_contents(public_path('maintenance.html')), 503)
                ->header('Content-Type', 'text/html');
        }

        return $next($request);
    }

    /**
     * Check if maintenance mode is enabled from database settings.
     *
     * @return bool
     */
    protected function isMaintenanceMode(): bool
    {
        $settings = Cache::get('main-setting');

        if ($settings && isset($settings['info_status'])) {
            return $settings['info_status'] === 'close';
        }

        $option = Option::where('option_name', 'info_status')->first();

        return $option && $option->option_value === 'close';
    }

    /**
     * Check if the request URI is excluded from maintenance mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isExcluded(Request $request): bool
    {
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
