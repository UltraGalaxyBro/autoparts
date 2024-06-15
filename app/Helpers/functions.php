<?php

if (!function_exists('remove_query_parameter')) {
    function remove_query_parameter($parameter) {
        $query = request()->query();
        unset($query[$parameter]);
        return request()->url() . (empty($query) ? '' : '?' . http_build_query($query));
    }
}
