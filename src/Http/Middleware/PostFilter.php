<?php

namespace Anomaly\PostFilterExtension\Http\Middleware;

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

        if ($request->method() != 'POST') {
            return $next($request);
        }

        if (!$blacklist = config('anomaly.extension.post_filter::filter.blacklist')) {
            return $next($request);
        }

        if (is_string($blacklist)) {
            $blacklist = explode("\r\n", $blacklist);
        }

        $blacklist = array_filter(
            (array) $blacklist,
            function ($item) {
                return !empty(trim($item));
            }
        );

        $post = array_filter(
            $request->post(),
            function ($value) {

                if (is_array($value)) {
                    return !empty(array_filter($value));
                }

                return !empty(trim($value));
            }
        );

        if (!$blacklist || !$post) {
            return $next($request);
        }

        foreach ($post as $key => $value) {
            foreach ($blacklist as $term) {
                if (is_string($value) && strpos(strtolower($value), strtolower($term)) !== false) {
                    abort(422, trans('anomaly.extension.post_filter::message.blacklist_error'));
                }
            }
        }

        return $next($request);
    }
}
