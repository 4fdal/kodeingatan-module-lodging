<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['api'],
    'prefix' => config('lodging.api.prefix'),
    'as' => 'lodging.api.',
], function () {
});
