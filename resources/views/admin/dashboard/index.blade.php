@extends('layouts.app')

@section('content')
    <h1>Super Admin Dashboard</h1>
    <div class="grid">
        <div class="card"><strong>Users</strong><p>{{ $userCount }}</p></div>
        <div class="card"><strong>Tenants</strong><p>{{ $tenantCount }}</p></div>
        <div class="card"><strong>Active Tenants</strong><p>{{ $activeTenantCount }}</p></div>
        <div class="card"><strong>Plans</strong><p>{{ $planCount }}</p></div>
    </div>
@endsection
