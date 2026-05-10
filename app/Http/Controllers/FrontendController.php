<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master;
use App\Models\Service;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\Faq;
use App\Models\Contact;
use App\Models\CompanyDetails;
use App\Models\Slider;

class FrontendController extends Controller
{
    private function getTenant()
    {
        $tenant = app()->bound('currentTenant') ? app('currentTenant') : null;
        if (!$tenant) abort(404);
        return $tenant;
    }

    private function getCompany($tenantId)
    {
        return CompanyDetails::where('tenant_id', $tenantId)->first();
    }

    private function getMaster($tenantId, $page, $name = null)
    {
        $query = Master::where('tenant_id', $tenantId)->where('page', $page);
        if ($name) $query->where('name', $name);
        return $name ? $query->first() : $query->get();
    }

    public function index()
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'home');
        $sliders = Slider::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->get();
        $services = Service::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->take(6)->get();
        $posts    = Post::where('tenant_id', $tenant->id)->where('status', 1)->latest()->take(3)->get();

        return view('frontend.index', compact('tenant', 'company', 'masters', 'sliders', 'services', 'posts'));
    }

    public function about()
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'about');

        return view('frontend.about', compact('tenant', 'company', 'masters'));
    }

    public function services()
    {
        $tenant   = $this->getTenant();
        $company  = $this->getCompany($tenant->id);
        $masters  = $this->getMaster($tenant->id, 'services');
        $services = Service::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->get();

        return view('frontend.services', compact('tenant', 'company', 'masters', 'services'));
    }

    public function serviceDetail($slug)
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $service = Service::where('tenant_id', $tenant->id)->where('slug', $slug)->where('status', 1)->firstOrFail();

        return view('frontend.service_detail', compact('tenant', 'company', 'service'));
    }

    public function gallery()
    {
        $tenant   = $this->getTenant();
        $company  = $this->getCompany($tenant->id);
        $masters  = $this->getMaster($tenant->id, 'gallery');
        $galleries = Gallery::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->get();

        return view('frontend.gallery', compact('tenant', 'company', 'masters', 'galleries'));
    }

    public function blog()
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'blog');
        $posts   = Post::where('tenant_id', $tenant->id)->where('status', 1)->latest()->paginate(12);

        return view('frontend.blogs', compact('tenant', 'company', 'masters', 'posts'));
    }

    public function blogDetail($slug)
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $post    = Post::where('tenant_id', $tenant->id)->where('slug', $slug)->where('status', 1)->firstOrFail();

        return view('frontend.blog_detail', compact('tenant', 'company', 'post'));
    }

    public function faq()
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'faq');
        $faqs    = Faq::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->get();

        return view('frontend.faq', compact('tenant', 'company', 'masters', 'faqs'));
    }

    public function contact()
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'contact');

        return view('frontend.contact', compact('tenant', 'company', 'masters'));
    }

    public function contactSubmit(Request $request)
    {
        $tenant = $this->getTenant();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:20',
            'subject'    => 'nullable|string|max:255',
            'message'    => 'required|string',
        ]);

        Contact::create([
            'tenant_id'  => $tenant->id,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'subject'    => $request->subject,
            'message'    => $request->message,
        ]);

        return back()->with('success', 'Thank you ' . $request->first_name . '! Your message has been received.');
    }
}