<?php namespace Anomaly\PostFilterExtension;

use Anomaly\PostFilterExtension\Http\Middleware\PostFilter;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

/**
 * Class PostFilterExtensionServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PostFilterExtensionServiceProvider extends AddonServiceProvider
{

    /**
     * The addon middleware.
     *
     * @type array|null
     */
    protected $middleware = [
        PostFilter::class,
    ];

}
