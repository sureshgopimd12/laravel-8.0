<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\Page;
use App\Models\Plan;
use App\Models\Section;
use App\Models\Tenant;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoTenantSeeder extends Seeder
{
    public function run(): void
    {
        $plan = Plan::firstOrCreate([
            'slug' => 'pro',
        ], [
            'name' => 'Pro',
            'price_monthly' => 29,
            'price_yearly' => 290,
            'limits' => ['pages' => 100, 'sites' => 10],
            'features' => ['custom_domain' => true, 'api_access' => true],
            'is_active' => true,
        ]);

        $theme = Theme::firstOrCreate([
            'key' => 'default',
        ], [
            'name' => 'Default Theme',
            'description' => 'Fast multipurpose starter theme.',
            'is_active' => true,
        ]);

        $owner = User::firstOrCreate([
            'email' => 'owner@example.com',
        ], [
            'name' => 'Demo Owner',
            'password' => Hash::make('password'),
            'role' => 'tenant_owner',
        ]);

        $tenant = Tenant::firstOrCreate([
            'slug' => 'demo-site',
        ], [
            'owner_id' => $owner->id,
            'plan_id' => $plan->id,
            'theme_id' => $theme->id,
            'name' => 'Demo Marketing Site',
            'status' => 'active',
            'settings' => ['locale' => 'en', 'timezone' => 'UTC'],
        ]);

        Domain::firstOrCreate([
            'domain' => 'demo.yourapp.com',
        ], [
            'tenant_id' => $tenant->id,
            'is_primary' => true,
            'is_verified' => true,
        ]);

        $page = Page::firstOrCreate([
            'tenant_id' => $tenant->id,
            'slug' => 'home',
        ], [
            'title' => 'Home',
            'meta_title' => 'Demo Site Home',
            'meta_description' => 'Demo tenant homepage',
            'status' => 'published',
            'is_homepage' => true,
            'published_at' => now(),
        ]);

        Section::firstOrCreate([
            'page_id' => $page->id,
            'type' => 'hero',
            'sort_order' => 1,
        ], [
            'content' => [
                'headline' => 'Build your SaaS website faster',
                'subheadline' => 'Tenant-aware CMS blocks with Blade rendering.',
                'cta_text' => 'Start free trial',
            ],
            'is_reusable' => true,
        ]);
    }
}
