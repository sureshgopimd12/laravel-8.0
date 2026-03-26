<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\PageRepository;

class SiteController extends Controller
{
    public function __construct(private readonly PageRepository $pageRepository)
    {
    }

    public function home()
    {
        $tenant = app('currentTenant');
        $page = $this->pageRepository->homepage($tenant->id);

        abort_if(! $page, 404, 'Homepage not found.');

        return view('frontend.themes.default.page', compact('tenant', 'page'));
    }

    public function show(string $slug)
    {
        $tenant = app('currentTenant');
        $page = $this->pageRepository->findBySlug($tenant->id, $slug);

        abort_if(! $page, 404, 'Page not found.');

        return view('frontend.themes.default.page', compact('tenant', 'page'));
    }
}
