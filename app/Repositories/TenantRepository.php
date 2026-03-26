<?php

namespace App\Repositories;

use App\Models\Tenant;

class TenantRepository
{
    public function create(array $data): Tenant
    {
        return Tenant::create($data);
    }

    public function findByDomain(string $domain): ?Tenant
    {
        return Tenant::query()
            ->whereHas('domains', function ($query) use ($domain) {
                $query->where('domain', $domain)->where('is_verified', true);
            })
            ->with(['domains', 'theme', 'plan'])
            ->first();
    }
}
