@extends('layouts.app')

@section('content')
    <h1>Create Page</h1>
    <form method="post" action="{{ route('tenant.pages.store') }}" class="card">
        @csrf
        <label>Title <input type="text" name="title" required></label>
        <label>Slug <input type="text" name="slug"></label>
        <label>Meta Title <input type="text" name="meta_title"></label>
        <label>Meta Description <textarea name="meta_description"></textarea></label>
        <label>Status
            <select name="status">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
                <option value="archived">Archived</option>
            </select>
        </label>
        <label><input type="checkbox" name="is_homepage" value="1"> Homepage</label>
        <button class="btn" type="submit">Save and open builder</button>
    </form>
@endsection
