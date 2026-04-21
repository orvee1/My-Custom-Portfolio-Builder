<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        abort_unless(auth()->check(), 403);
    }

    protected function ensureSuperAdmin(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403);
    }

    public function index(Request $request): View
    {
        $this->ensureSuperAdmin();

        $users = User::query()
            ->with('creator:id,name')
            ->where('role', 'admin') // this module manages admin users only
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
        $this->ensureSuperAdmin();

        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->ensureSuperAdmin();

        DB::transaction(function () use ($request) {
            User::create([
                'name'       => trim($request->name),
                'email'      => strtolower(trim($request->email)),
                'password'   => $request->password,
                'role'       => 'admin',
                'created_by' => auth()->id(),
                'is_active'  => $request->boolean('is_active', true),
            ]);
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user created successfully.');
    }

    public function edit(User $user): View
    {
        $this->ensureSuperAdmin();

        abort_if($user->role !== 'admin', 404);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->ensureSuperAdmin();

        abort_if($user->role !== 'admin', 404);

        if ($user->id === auth()->id()) {
            return back()
                ->withErrors([
                    'user' => 'Use the profile page to update your own account.',
                ])
                ->withInput();
        }

        $data = [
            'name'      => trim($request->name),
            'email'     => strtolower(trim($request->email)),
            'is_active' => $request->boolean('is_active'),
            'role'      => 'admin',
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        DB::transaction(function () use ($user, $data) {
            $user->update($data);
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->ensureSuperAdmin();

        abort_if($user->role !== 'admin', 404);

        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'user' => 'You cannot delete your own account.',
            ]);
        }

        DB::transaction(function () use ($user) {
            $user->delete();
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user deleted successfully.');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        $this->ensureSuperAdmin();

        abort_if($user->role !== 'admin', 404);

        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'user' => 'You cannot change your own active status.',
            ]);
        }

        DB::transaction(function () use ($user) {
            $user->update([
                'is_active' => ! $user->is_active,
            ]);
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user status updated successfully.');
    }
}
