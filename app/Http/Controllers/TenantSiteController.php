<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantSiteController extends Controller
{
    private function getTenant()
    {
        $tenant = app()->bound('currentTenant') ? app('currentTenant') : null;
        if (!$tenant) abort(404);
        return $tenant;
    }

    public function index()
    {
        $tenant = $this->getTenant();
        return view('tenant.home', compact('tenant'));
    }

    public function about()
    {
        $tenant = $this->getTenant();
        $data = [
            'title'       => 'About Us',
            'description' => 'We are a charity dedicated to helping people in need.',
            'team'        => [
                ['name' => 'John Doe',   'role' => 'Director',       'image' => null],
                ['name' => 'Jane Smith', 'role' => 'Coordinator',    'image' => null],
                ['name' => 'Bob Jones',  'role' => 'Volunteer Lead', 'image' => null],
            ],
        ];
        return view('tenant.about', compact('tenant', 'data'));
    }

    public function contact()
    {
        $tenant = $this->getTenant();
        return view('tenant.contact', compact('tenant'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'message' => 'required',
        ]);

        // Store in session to show on thank you
        session([
            'contact_name'    => $request->name,
            'contact_email'   => $request->email,
            'contact_message' => $request->message,
        ]);

        return back()->with('success', 'Thank you ' . $request->name . '! Your message has been received. We will get back to you at ' . $request->email . ' shortly.');
    }

    public function services()
    {
        $tenant = $this->getTenant();
        $services = [
            ['slug' => 'food-aid',        'title' => 'Food Aid',        'description' => 'Providing food to families in need.',  'icon' => 'ri-restaurant-line'],
            ['slug' => 'education',       'title' => 'Education',       'description' => 'Supporting children with education.',  'icon' => 'ri-book-line'],
            ['slug' => 'mental-health',   'title' => 'Mental Health',   'description' => 'Offering mental health support.',      'icon' => 'ri-heart-line'],
            ['slug' => 'housing-support', 'title' => 'Housing Support', 'description' => 'Helping people find safe housing.',    'icon' => 'ri-home-line'],
        ];
        return view('tenant.services.index', compact('tenant', 'services'));
    }

    public function serviceDetail($slug)
    {
        $tenant = $this->getTenant();
        $services = [
            'food-aid'        => ['title' => 'Food Aid',        'description' => 'We provide weekly food parcels to over 500 families across the region.', 'icon' => 'ri-restaurant-line'],
            'education'       => ['title' => 'Education',       'description' => 'We support over 200 children with tutoring and school supplies.',         'icon' => 'ri-book-line'],
            'mental-health'   => ['title' => 'Mental Health',   'description' => 'Our trained counselors offer free mental health sessions.',               'icon' => 'ri-heart-line'],
            'housing-support' => ['title' => 'Housing Support', 'description' => 'We work with local councils to help vulnerable people find housing.',     'icon' => 'ri-home-line'],
        ];
        if (!isset($services[$slug])) abort(404);
        $service = $services[$slug];
        return view('tenant.services.detail', compact('tenant', 'service'));
    }
}