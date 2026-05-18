<?php

test('returns a successful response', function () {
    $response = $this->get(route('welcome'));

    $response
        ->assertOk()
        ->assertSee('Portfolio Builder')
        ->assertSee('Your portfolio should look hired before you are.');
});
