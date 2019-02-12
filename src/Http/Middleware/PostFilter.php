<?php namespace Anomaly\PostFilterExtension\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class PostFilter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PostFilter
{

    /**
     * Check for and set namespace if present.
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (IS_ADMIN) {
            return $next($request);
        }

        if (!$request->post()) {
            return $next($request);
        }

        $blacklist = config('anomaly.extension.post_filter::filter.blacklist');

        if (is_string($blacklist)) {
            $blacklist = explode("\r\n", $blacklist);
        }

        foreach ($request->post() as $key => $value) {
            foreach ($blacklist as $term) {
                if (strpos(strtolower($value), strtolower($term)) !== false) {
                    abort(422, trans('anomaly.extension.post_filter::message.blacklist_error'));
                }
            }
        }

        return $next($request);
    }
}
