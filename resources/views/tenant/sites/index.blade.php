@extends('layouts.app')

@section('content')
    <h1>Your Websites</h1>
    <a class="btn" href="{{ route('tenant.sites.create') }}">Create Website</a>

    @foreach($sites as $site)
        <div class="card">
            <h3>{{ $site->name }}</h3>
            <p>Status: {{ $site->status }}</p>
            <p>Domain: {{ optional($site->domains->first())->domain }}</p>
        </div>
    @endforeach
@endsection
