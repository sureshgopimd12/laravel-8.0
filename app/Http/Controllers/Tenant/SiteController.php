<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreTenantRequest;
use App\Models\Theme;
use App\Services\TenantService;

class SiteController extends Controller
{
    public function __construct(private readonly TenantService $tenantService)
    {
    }

    public function index()
    {
        $sites = auth()->user()->ownedTenants()->with('domains')->latest()->get();

        return view('tenant.sites.index', compact('sites'));
    }

    public function create()
    {
        return view('tenant.sites.create', [
            'themes' => Theme::query()->where('is_active', true)->get(),
        ]);
    }

    public function store(StoreTenantRequest $request)
    {
        $this->tenantService->createWebsite($request->validated(), auth()->id());

        return redirect()->route('tenant.sites.index')->with('status', 'Website created successfully.');
    }
}
