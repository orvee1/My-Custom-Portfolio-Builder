<?php

use App\Models\Portfolio;
use App\Models\PortfolioProject;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('published portfolio page is visible to the public', function () {
    $user = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);

    $portfolio = Portfolio::create([
        'user_id' => $user->id,
        'slug' => 'jane-doe',
        'portfolio_title' => 'Jane Doe Portfolio',
        'full_name' => 'Jane Doe',
        'profession_title' => 'Laravel Developer',
        'tagline' => 'Building thoughtful digital products.',
        'status' => 'published',
        'is_public' => true,
        'template_key' => 'creative_dark',
        'accent_color' => '#ea580c',
    ]);

    PortfolioProject::create([
        'portfolio_id' => $portfolio->id,
        'title' => 'Client Portal',
        'slug' => 'client-portal',
        'short_description' => 'A streamlined internal operations platform.',
        'is_enabled' => true,
        'sort_order' => 1,
    ]);

    $this->get(route('public.portfolios.show', $portfolio->slug))
        ->assertOk()
        ->assertSee('Jane Doe')
        ->assertSee('Laravel Developer')
        ->assertSee('Client Portal');
});
