<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Multi-Tenant CMS SaaS' }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body{font-family:Arial,sans-serif;max-width:1100px;margin:0 auto;padding:24px}
        .card{border:1px solid #ddd;padding:16px;border-radius:8px;margin-bottom:16px}
        .grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
        input,select,textarea{width:100%;padding:8px;margin-top:4px}
        .btn{background:#111;color:#fff;padding:8px 12px;border-radius:6px;border:0;cursor:pointer}
    </style>
</head>
<body>
    @if(session('status'))
        <div class="card">{{ session('status') }}</div>
    @endif

    @yield('content')
</body>
</html>
