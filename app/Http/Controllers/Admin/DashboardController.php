<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $authUser = Auth::user();

        if ($authUser->isSuperAdmin()) {
            $stats = [
                [
                    'label' => 'Total Admin Users',
                    'value' => User::query()->where('role', 'admin')->count(),
                ],
                [
                    'label' => 'Published Portfolios',
                    'value' => Portfolio::query()->where('status', 'published')->count(),
                ],
                [
                    'label' => 'Uploaded Resumes',
                    'value' => DB::table('portfolio_resumes')->count(),
                ],
                [
                    'label' => 'Contact Messages',
                    'value' => DB::table('portfolio_contact_messages')->count(),
                ],
            ];
        } else {
            $portfolio = Portfolio::query()
                ->select('id', 'status', 'is_public')
                ->where('user_id', $authUser->id)
                ->first();

            $portfolioId = $portfolio?->id;

            $stats = [
                [
                    'label' => 'Portfolio Status',
                    'value' => $portfolio ? ucfirst($portfolio->status) : 'Not Created',
                ],
                [
                    'label' => 'Projects',
                    'value' => $portfolioId
                        ? DB::table('portfolio_projects')->where('portfolio_id', $portfolioId)->count()
                        : 0,
                ],
                [
                    'label' => 'Uploaded Resumes',
                    'value' => $portfolioId
                        ? DB::table('portfolio_resumes')->where('portfolio_id', $portfolioId)->count()
                        : 0,
                ],
                [
                    'label' => 'Contact Messages',
                    'value' => $portfolioId
                        ? DB::table('portfolio_contact_messages')->where('portfolio_id', $portfolioId)->count()
                        : 0,
                ],
            ];
        }

        return view('admin.dashboard', [
            'stats' => $stats,
        ]);
    }
}
