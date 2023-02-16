<?php

Route::group(['middleware' => ['web']], function () {
    Route::middleware('auth')->group(function () {

        // resource routes (index and delete)
        Route::resource(config('sptexception.log_dashboard_url'), 'Spt\ExceptionHandling\Http\ExceptionController');

    });
});
