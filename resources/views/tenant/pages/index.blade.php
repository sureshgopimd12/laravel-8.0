@extends('layouts.app')

@section('content')
    <h1>{{ $tenant->name }} - Pages</h1>
    <a class="btn" href="{{ route('tenant.pages.create') }}">New Page</a>

    @foreach($pages as $page)
        <div class="card">
            <strong>{{ $page->title }}</strong>
            <p>/{{ $page->slug }} · {{ $page->status }}</p>
            <a href="{{ route('tenant.pages.builder', $page) }}">Builder</a>
            <form method="post" action="{{ route('tenant.pages.duplicate', $page) }}">
                @csrf
                <button class="btn" type="submit">Duplicate</button>
            </form>
        </div>
    @endforeach

    {{ $pages->links() }}
@endsection
