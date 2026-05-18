<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\User;
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
                    'value' => DB::table('users')
                        ->where('role', 'admin')
                        ->count(),
                ],
                [
                    'label' => 'Pending Approvals',
                    'value' => DB::table('users')
                        ->where('role', 'admin')
                        ->where('approval_status', 'pending')
                        ->count(),
                ],
                [
                    'label' => 'Published Portfolios',
                    'value' => DB::table('portfolios')
                        ->where('status', 'published')
                        ->count(),
                ],
                [
                    'label' => 'Contact Messages',
                    'value' => DB::table('portfolio_contact_messages')->count(),
                ],
            ];
        } else {
            $portfolio = Portfolio::select('id', 'status', 'is_public')
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
                        ? DB::table('portfolio_projects')
                        ->where('portfolio_id', $portfolioId)
                        ->count()
                        : 0,
                ],
                [
                    'label' => 'Uploaded Resumes',
                    'value' => $portfolioId
                        ? DB::table('portfolio_resumes')
                        ->where('portfolio_id', $portfolioId)
                        ->count()
                        : 0,
                ],
                [
                    'label' => 'Contact Messages',
                    'value' => $portfolioId
                        ? DB::table('portfolio_contact_messages')
                        ->where('portfolio_id', $portfolioId)
                        ->count()
                        : 0,
                ],
            ];
        }

        return view('admin.dashboard', [
            'stats' => $stats,
        ]);
    }
}
