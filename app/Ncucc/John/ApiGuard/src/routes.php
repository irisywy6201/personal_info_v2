<?php

if (Config::get('api-guard::generateApiKeyRoute')) {
    Route::post('api/api-key', 'John\ApiGuard\Controllers\ApiKeyController@create');
}