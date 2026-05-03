<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortFolio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $authUser = auth()->user();

        if ($authUser->isSuperAdmin()) {
            $stats = [
                [
                    'label' => 'Total Admin Users',
                    'value' => User::query()->where('role', 'admin')->count(),
                ],
                [
                    'label' => 'Published Portfolios',
                    'value' => PortFolio::query()->where('status', 'published')->count(),
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
            $portfolio = PortFolio::query()
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
