@extends('layouts.app')

@section('content')
    <h1>Create Website</h1>
    <form method="post" action="{{ route('tenant.sites.store') }}" class="card">
        @csrf
        <label>Name <input type="text" name="name" required></label>
        <label>Subdomain <input type="text" name="subdomain" required></label>
        <label>Theme
            <select name="theme_id">
                <option value="">Default</option>
                @foreach($themes as $theme)
                    <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                @endforeach
            </select>
        </label>
        <button class="btn" type="submit">Create</button>
    </form>
@endsection
