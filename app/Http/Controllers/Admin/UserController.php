<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\PortFolio;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->with(['creator:id,name', 'portfolio:id,user_id,status'])
            ->where('role', 'admin')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim((string) $request->search);

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                if ($request->status === 'active') {
                    $query->where('is_active', true);
                } elseif ($request->status === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'       => trim($request->name),
                'email'      => strtolower(trim($request->email)),
                'password'   => $request->password,
                'role'       => 'admin',
                'created_by' => auth()->id(),
                'is_active'  => $request->boolean('is_active'),
            ]);

            PortFolio::create([
                'user_id'                 => $user->id,
                'slug'                    => $this->generateUniquePortfolioSlug($user->name),
                'portfolio_title'         => $user->name . "'s Portfolio",
                'full_name'               => $user->name,
                'email'                   => $user->email,
                'status'                  => 'draft',
                'is_public'               => false,
                'template_key'            => 'premium_modern',
                'resume_download_enabled' => true,
                'contact_form_enabled'    => true,
                'show_social_links'       => true,
            ]);
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user created successfully.');
    }

    public function edit(User $user): View
    {
        abort_if($user->role !== 'admin', 404);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        abort_if($user->role !== 'admin', 404);

        $email = strtolower(trim($request->email));

        $data = [
            'name'      => trim($request->name),
            'email'     => $email,
            'is_active' => $request->boolean('is_active'),
            'role'      => 'admin',
        ];

        if ($user->email !== $email) {
            $data['email_verified_at'] = null;
        }

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        DB::transaction(function () use ($user, $data) {
            $user->forceFill($data)->save();

            if ($user->portfolio) {
                $user->portfolio->update([
                    'full_name'               => $user->name,
                    'email'                   => $user->email,
                    'last_content_updated_at' => now(),
                ]);
            }
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->role !== 'admin', 404);

        DB::transaction(function () use ($user) {
            $user->delete();

            if ($user->portfolio) {
                $user->portfolio->delete();
            }
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user deleted successfully.');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        abort_if($user->role !== 'admin', 404);

        DB::transaction(function () use ($user) {
            $user->update([
                'is_active' => ! $user->is_active,
            ]);
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user status updated successfully.');
    }

    private function generateUniquePortfolioSlug(string $name): string
    {
        $baseSlug = Str::slug($name);

        if (! $baseSlug) {
            $baseSlug = 'portfolio';
        }

        $slug    = $baseSlug;
        $counter = 1;

        while (Portfolio::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
