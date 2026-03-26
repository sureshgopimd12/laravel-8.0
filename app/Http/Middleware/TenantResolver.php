<?php

namespace App\Http\Middleware;

use App\Repositories\TenantRepository;
use Closure;
use Illuminate\Http\Request;

class TenantResolver
{
    public function __construct(private readonly TenantRepository $tenantRepository)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $tenant = $this->tenantRepository->findByDomain($request->getHost());

        abort_if(! $tenant, 404, 'Tenant not found.');

        app()->instance('currentTenant', $tenant);

        return $next($request);
    }
}
