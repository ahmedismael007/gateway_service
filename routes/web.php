<?php

\Illuminate\Support\Facades\Route::get('/test', function () {
    return view('mails.user-email-confirm-mail');
});


