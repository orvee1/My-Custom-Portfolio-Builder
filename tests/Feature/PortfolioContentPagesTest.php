<?php

use App\Models\Portfolio;
use App\Models\PortfolioEducation;
use App\Models\PortfolioExperience;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('portfolio owner can view the experience and education content pages', function () {
    $user = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);

    $portfolio = Portfolio::create([
        'user_id' => $user->id,
        'slug' => 'jane-doe',
        'portfolio_title' => 'Jane Doe Portfolio',
        'full_name' => 'Jane Doe',
        'status' => 'draft',
        'is_public' => false,
        'template_key' => 'premium_modern',
    ]);

    $experience = PortfolioExperience::create([
        'portfolio_id' => $portfolio->id,
        'company_name' => 'Acme Inc',
        'job_title' => 'Senior Developer',
        'sort_order' => 1,
        'is_enabled' => true,
    ]);

    $education = PortfolioEducation::create([
        'portfolio_id' => $portfolio->id,
        'institution_name' => 'State University',
        'degree' => 'BSc',
        'sort_order' => 1,
        'is_enabled' => true,
    ]);

    $this->actingAs($user);

    $this->get(route('admin.portfolios.experiences.index', $portfolio))
        ->assertOk()
        ->assertSee('Experiences')
        ->assertSee('Acme Inc');

    $this->get(route('admin.portfolios.experiences.edit', [$portfolio, $experience]))
        ->assertOk()
        ->assertSee('Edit Experience')
        ->assertSee('Senior Developer');

    $this->get(route('admin.portfolios.educations.index', $portfolio))
        ->assertOk()
        ->assertSee('Educations')
        ->assertSee('State University');

    $this->get(route('admin.portfolios.educations.edit', [$portfolio, $education]))
        ->assertOk()
        ->assertSee('Edit Education')
        ->assertSee('State University');
});
