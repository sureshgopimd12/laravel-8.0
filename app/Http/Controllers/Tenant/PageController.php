<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StorePageRequest;
use App\Models\Page;
use App\Services\BillingService;
use App\Services\PageService;

class PageController extends Controller
{
    public function __construct(
        private readonly PageService $pageService,
        private readonly BillingService $billingService
    ) {
    }

    public function index()
    {
        $tenant = app('currentTenant');
        $pages = $tenant->pages()->latest()->paginate(20);

        return view('tenant.pages.index', compact('pages', 'tenant'));
    }

    public function create()
    {
        return view('tenant.pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $tenant = app('currentTenant');

        abort_if($this->billingService->exceedsPageLimit($tenant), 422, 'Plan page limit reached.');

        $page = $this->pageService->createPage($tenant->id, $request->validated());

        return redirect()->route('tenant.pages.builder', $page)->with('status', 'Page created.');
    }

    public function builder(Page $page)
    {
        $page->load('sections');

        return view('tenant.sections.builder', compact('page'));
    }

    public function updateSections(Page $page)
    {
        $sections = request()->validate([
            'sections' => ['required', 'array'],
            'sections.*.type' => ['required', 'string', 'max:100'],
            'sections.*.content' => ['nullable', 'array'],
            'sections.*.is_reusable' => ['nullable', 'boolean'],
        ])['sections'];

        $this->pageService->saveSections($page, $sections);

        return redirect()->back()->with('status', 'Page sections saved.');
    }

    public function duplicate(Page $page)
    {
        $copy = $this->pageService->duplicate($page->load('sections'));

        return redirect()->route('tenant.pages.builder', $copy)->with('status', 'Page duplicated.');
    }
}
