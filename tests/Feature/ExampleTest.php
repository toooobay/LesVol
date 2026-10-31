<?php

test('public pages load', function (string $path) {
    $this->get($path)->assertOk();
})->with(['/', '/login', '/register']);

test('guests are redirected to login', function () {
    $this->get('/home')->assertRedirect('/login');
});
