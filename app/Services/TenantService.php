<?php

namespace App\Services;

use App\Models\Domain;
use App\Models\Tenant;
use App\Repositories\TenantRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantService
{
    public function __construct(private readonly TenantRepository $tenantRepository)
    {
    }

    public function createWebsite(array $payload, int $ownerId): Tenant
    {
        return DB::transaction(function () use ($payload, $ownerId) {
            $tenant = $this->tenantRepository->create([
                'owner_id' => $ownerId,
                'name' => $payload['name'],
                'slug' => Str::slug($payload['name']) . '-' . Str::random(5),
                'plan_id' => $payload['plan_id'] ?? null,
                'theme_id' => $payload['theme_id'] ?? null,
                'status' => 'active',
                'settings' => [
                    'locale' => 'en',
                    'timezone' => 'UTC',
                ],
            ]);

            Domain::create([
                'tenant_id' => $tenant->id,
                'domain' => $payload['subdomain'] . '.yourapp.com',
                'is_primary' => true,
                'is_verified' => true,
            ]);

            return $tenant;
        });
    }
}
