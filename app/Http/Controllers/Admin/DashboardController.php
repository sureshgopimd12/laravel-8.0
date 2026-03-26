<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard.index', [
            'userCount' => User::query()->count(),
            'tenantCount' => Tenant::query()->count(),
            'activeTenantCount' => Tenant::query()->where('status', 'active')->count(),
            'planCount' => Plan::query()->count(),
        ]);
    }
}
