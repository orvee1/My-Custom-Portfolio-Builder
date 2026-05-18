<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\PortfolioEducationController;
use App\Http\Controllers\Admin\PortfolioExperienceController;
use App\Http\Controllers\Admin\PortfolioProjectController;
use App\Http\Controllers\Admin\PortfolioSkillController;
use App\Http\Controllers\Admin\PortfolioSocialLinkController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PublicPortfolioController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::get('/p/{slug}', [PublicPortfolioController::class, 'show'])
    ->name('public.portfolios.show');
Route::middleware(['auth', 'active_user'])
    ->get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })
    ->name('dashboard');
Route::middleware(['auth', 'active_user'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/my-portfolio', [PortfolioController::class, 'mine'])->name('portfolios.mine');

    Route::get('/portfolios/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolios.edit');
    Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update');
    Route::patch('/portfolios/{portfolio}/toggle-publish', [PortfolioController::class, 'togglePublish'])->name('portfolios.toggle-publish');
    Route::get('/portfolios/{portfolio}/preview', [PortfolioController::class, 'preview'])->name('portfolios.preview');

    Route::prefix('/portfolios/{portfolio}')
        ->name('portfolios.')
        ->group(function () {
            Route::get('/projects', [PortfolioProjectController::class, 'index'])->name('projects.index');
            Route::post('/projects', [PortfolioProjectController::class, 'store'])->name('projects.store');
            Route::get('/projects/{project}/edit', [PortfolioProjectController::class, 'edit'])->name('projects.edit');
            Route::put('/projects/{project}', [PortfolioProjectController::class, 'update'])->name('projects.update');
            Route::delete('/projects/{project}', [PortfolioProjectController::class, 'destroy'])->name('projects.destroy');

            Route::get('/experiences', [PortfolioExperienceController::class, 'index'])->name('experiences.index');
            Route::post('/experiences', [PortfolioExperienceController::class, 'store'])->name('experiences.store');
            Route::get('/experiences/{experience}/edit', [PortfolioExperienceController::class, 'edit'])->name('experiences.edit');
            Route::put('/experiences/{experience}', [PortfolioExperienceController::class, 'update'])->name('experiences.update');
            Route::delete('/experiences/{experience}', [PortfolioExperienceController::class, 'destroy'])->name('experiences.destroy');

            Route::get('/educations', [PortfolioEducationController::class, 'index'])->name('educations.index');
            Route::post('/educations', [PortfolioEducationController::class, 'store'])->name('educations.store');
            Route::get('/educations/{education}/edit', [PortfolioEducationController::class, 'edit'])->name('educations.edit');
            Route::put('/educations/{education}', [PortfolioEducationController::class, 'update'])->name('educations.update');
            Route::delete('/educations/{education}', [PortfolioEducationController::class, 'destroy'])->name('educations.destroy');

            Route::get('/skills', [PortfolioSkillController::class, 'index'])->name('skills.index');
            Route::post('/skills', [PortfolioSkillController::class, 'store'])->name('skills.store');
            Route::get('/skills/{skill}/edit', [PortfolioSkillController::class, 'edit'])->name('skills.edit');
            Route::put('/skills/{skill}', [PortfolioSkillController::class, 'update'])->name('skills.update');
            Route::delete('/skills/{skill}', [PortfolioSkillController::class, 'destroy'])->name('skills.destroy');

            Route::get('/social-links', [PortfolioSocialLinkController::class, 'index'])->name('social-links.index');
            Route::post('/social-links', [PortfolioSocialLinkController::class, 'store'])->name('social-links.store');
            Route::get('/social-links/{socialLink}/edit', [PortfolioSocialLinkController::class, 'edit'])->name('social-links.edit');
            Route::put('/social-links/{socialLink}', [PortfolioSocialLinkController::class, 'update'])->name('social-links.update');
            Route::delete('/social-links/{socialLink}', [PortfolioSocialLinkController::class, 'destroy'])->name('social-links.destroy');
        });

    Route::middleware(['super_admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolios.index');
    });
});
