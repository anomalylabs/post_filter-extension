<?php

return [
    'blacklist' => array_filter(explode(',', env('POST_FILTER_BLACKLIST'))),
];
