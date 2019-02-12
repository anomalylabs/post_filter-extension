<?php

return [
    'blacklist' => [
        'env'  => 'POST_FILTER_BLACKLIST',
        'type' => 'anomaly.field_type.textarea',
        'bind' => 'anomaly.extension.post_filter::filter.blacklist',
    ],
];
