<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    public function run(): void
    {
        Section::truncate();

        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            $homeSection = [
                ['tenant_id' => $tenant->id, 'page' => 'home', 'name' => 'slider',        'sl' => 1, 'status' => 1],
                ['tenant_id' => $tenant->id, 'page' => 'home', 'name' => 'services',      'sl' => 2, 'status' => 1],
                ['tenant_id' => $tenant->id, 'page' => 'home', 'name' => 'difference',    'sl' => 3, 'status' => 1],
                ['tenant_id' => $tenant->id, 'page' => 'home', 'name' => 'stats',         'sl' => 4, 'status' => 1],
                ['tenant_id' => $tenant->id, 'page' => 'home', 'name' => 'latest_post',   'sl' => 5, 'status' => 1],
                ['tenant_id' => $tenant->id, 'page' => 'home', 'name' => 'testimonials',  'sl' => 6, 'status' => 1],
                ['tenant_id' => $tenant->id, 'page' => 'home', 'name' => 'gallery',       'sl' => 7, 'status' => 1],
                ['tenant_id' => $tenant->id, 'page' => 'home', 'name' => 'faq',           'sl' => 8, 'status' => 1],
            ];

            $aboutSections = [
                ['tenant_id' => $tenant->id, 'page' => 'about', 'name' => 'story',    'sl' => 1, 'status' => 1],
                ['tenant_id' => $tenant->id, 'page' => 'about', 'name' => 'beliefs',  'sl' => 2, 'status' => 1],
                ['tenant_id' => $tenant->id, 'page' => 'about', 'name' => 'team',     'sl' => 3, 'status' => 1],
            ];

            foreach (array_merge($homeSection, $aboutSections) as $section) {
                Section::create($section);
            }
        }
    }
}