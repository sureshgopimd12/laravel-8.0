<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->meta_title ?? $page->title }}</title>
    <meta name="description" content="{{ $page->meta_description }}">
</head>
<body>
    @foreach($page->sections as $section)
        @if($section->type === 'hero')
            <section style="padding:40px;background:#f5f7ff;">
                <h1>{{ data_get($section->content, 'headline') }}</h1>
                <p>{{ data_get($section->content, 'subheadline') }}</p>
                <a href="#">{{ data_get($section->content, 'cta_text') }}</a>
            </section>
        @else
            <section style="padding:30px;">
                <h2>{{ data_get($section->content, 'headline') }}</h2>
                <p>{{ data_get($section->content, 'body') }}</p>
            </section>
        @endif
    @endforeach
</body>
</html>
