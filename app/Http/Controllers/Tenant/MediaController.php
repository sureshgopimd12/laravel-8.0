<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Media;

class MediaController extends Controller
{
    public function index()
    {
        $tenant = app('currentTenant');
        $media = $tenant->media()->latest()->paginate(30);

        return view('tenant.media.index', compact('media'));
    }

    public function store()
    {
        $validated = request()->validate([
            'file' => ['required', 'file', 'max:5120'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        $path = $validated['file']->store('tenant-media/' . app('currentTenant')->id, 'public');

        Media::create([
            'tenant_id' => app('currentTenant')->id,
            'uploaded_by' => auth()->id(),
            'disk' => 'public',
            'path' => $path,
            'mime_type' => $validated['file']->getClientMimeType(),
            'size' => $validated['file']->getSize(),
            'alt_text' => $validated['alt_text'] ?? null,
            'metadata' => [],
        ]);

        return back()->with('status', 'Media uploaded.');
    }
}
