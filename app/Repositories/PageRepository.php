<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository
{
    public function create(array $data): Page
    {
        return Page::create($data);
    }

    public function findBySlug(int $tenantId, string $slug): ?Page
    {
        return Page::query()
            ->where('tenant_id', $tenantId)
            ->where('slug', $slug)
            ->where('status', 'published')
            ->with('sections')
            ->first();
    }

    public function homepage(int $tenantId): ?Page
    {
        return Page::query()
            ->where('tenant_id', $tenantId)
            ->where('is_homepage', true)
            ->where('status', 'published')
            ->with('sections')
            ->first();
    }
}
