@extends('layouts.app')

@section('content')
    <h1>Media Manager</h1>

    <form method="post" action="{{ route('tenant.media.store') }}" enctype="multipart/form-data" class="card">
        @csrf
        <label>File <input type="file" name="file" required></label>
        <label>Alt text <input type="text" name="alt_text"></label>
        <button type="submit" class="btn">Upload</button>
    </form>

    <div class="grid">
        @foreach($media as $item)
            <div class="card">
                <img src="{{ asset('storage/' . $item->path) }}" alt="{{ $item->alt_text }}" style="width:100%;height:120px;object-fit:cover">
                <small>{{ $item->mime_type }} · {{ $item->size }} bytes</small>
            </div>
        @endforeach
    </div>

    {{ $media->links() }}
@endsection
