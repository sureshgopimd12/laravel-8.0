<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;

class BillingService
{
    public function subscribe(Tenant $tenant, Plan $plan, string $providerSubscriptionId): Subscription
    {
        return Subscription::updateOrCreate(
            ['tenant_id' => $tenant->id],
            [
                'plan_id' => $plan->id,
                'provider' => 'stripe',
                'provider_subscription_id' => $providerSubscriptionId,
                'status' => 'active',
                'trial_ends_at' => now()->addDays(14),
                'ends_at' => null,
            ]
        );
    }

    public function exceedsPageLimit(Tenant $tenant): bool
    {
        $maxPages = data_get($tenant->plan?->limits, 'pages', PHP_INT_MAX);

        return $tenant->pages()->count() >= $maxPages;
    }
}
