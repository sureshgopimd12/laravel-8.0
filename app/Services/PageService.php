<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Section;
use App\Repositories\PageRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageService
{
    public function __construct(private readonly PageRepository $pageRepository)
    {
    }

    public function createPage(int $tenantId, array $payload): Page
    {
        return $this->pageRepository->create([
            'tenant_id' => $tenantId,
            'title' => $payload['title'],
            'slug' => $payload['slug'] ?? Str::slug($payload['title']),
            'meta_title' => $payload['meta_title'] ?? $payload['title'],
            'meta_description' => $payload['meta_description'] ?? null,
            'status' => $payload['status'] ?? 'draft',
            'is_homepage' => $payload['is_homepage'] ?? false,
            'published_at' => ($payload['status'] ?? null) === 'published' ? now() : null,
        ]);
    }

    public function saveSections(Page $page, array $sections): void
    {
        DB::transaction(function () use ($page, $sections) {
            $page->sections()->delete();

            foreach ($sections as $index => $section) {
                Section::create([
                    'page_id' => $page->id,
                    'type' => $section['type'],
                    'content' => $section['content'] ?? [],
                    'sort_order' => $index + 1,
                    'is_reusable' => $section['is_reusable'] ?? false,
                ]);
            }
        });
    }

    public function duplicate(Page $page): Page
    {
        return DB::transaction(function () use ($page) {
            $copy = $page->replicate();
            $copy->title = $page->title . ' (Copy)';
            $copy->slug = $page->slug . '-copy-' . Str::random(4);
            $copy->status = 'draft';
            $copy->published_at = null;
            $copy->save();

            foreach ($page->sections as $section) {
                Section::create([
                    'page_id' => $copy->id,
                    'type' => $section->type,
                    'content' => $section->content,
                    'sort_order' => $section->sort_order,
                    'is_reusable' => $section->is_reusable,
                ]);
            }

            return $copy;
        });
    }
}
