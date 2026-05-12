<?php

namespace App\Http\Controllers;

use App\Models\CompanyDetails;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Master;
use App\Models\Post;
use App\Models\Section;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Testimonial;
use Illuminate\Http\Request;

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
        $sections = Section::where('tenant_id', $tenant->id)->where('page', 'home')->where('status', 1)->orderBy('sl')->pluck('name');
        $sliders = Slider::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->get();
        $difference = $masters->firstWhere('name', 'difference');
        $serviceContent = $masters->firstWhere('name', 'services');
        $services = Service::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->limit(4)->get();
        $stats = $masters->firstWhere('name', 'stats');
        $latestPost = Post::where('tenant_id', $tenant->id)->where('status', 1)->latest()->first();
        $testimonialsSection = $masters->firstWhere('name', 'testimonials');
        $testimonials = Testimonial::where('tenant_id', $tenant->id)->where('status', 1)->latest()->get();
        $galleries = Gallery::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->get();
        $gallerySection = $masters->firstWhere('name', 'gallery');

        $faqs    = Faq::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->get();

        return view('frontend.index', compact('sections', 'sliders', 'difference', 'serviceContent', 'services', 'stats', 'latestPost', 'testimonialsSection', 'testimonials', 'galleries', 'gallerySection', 'faqs'));
    }

    public function about()
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'about');
        $sections = Section::where('tenant_id', $tenant->id)->where('page', 'about')->where('status', 1)->orderBy('sl')->pluck('name');
        $hero    = $masters->firstWhere('name', 'hero');
        $story   = $masters->firstWhere('name', 'story');
        $beliefs = $masters->firstWhere('name', 'beliefs');
        $team    = $masters->firstWhere('name', 'team');

        return view('frontend.about', compact('sections','hero', 'story', 'beliefs', 'team'));
    }

    public function services()
    {
        $tenant   = $this->getTenant();
        $company  = $this->getCompany($tenant->id);
        $masters  = $this->getMaster($tenant->id, 'services');
        $hero     = $masters->firstWhere('name', 'hero');
        $stats    = $masters->firstWhere('name', 'stats');
        $services = Service::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->get();

        return view('frontend.services', compact('hero', 'stats', 'services'));
    }

    public function serviceDetail($slug)
    {
        $tenant   = $this->getTenant();
        $company  = $this->getCompany($tenant->id);
        $service  = Service::where('tenant_id', $tenant->id)->where('slug', $slug)->where('status', 1)->firstOrFail();
        $masters  = $this->getMaster($tenant->id, 'services');
        $hero     = $masters->firstWhere('name', 'hero');
        $services = Service::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->get();

        return view('frontend.service_detail', compact('tenant', 'company', 'service', 'hero', 'services'));
    }

    public function gallery()
    {
        $tenant    = $this->getTenant();
        $company   = $this->getCompany($tenant->id);
        $masters   = $this->getMaster($tenant->id, 'other');
        $hero      = $masters->firstWhere('name', 'hero');
        $galleries = Gallery::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->get();

        return view('frontend.gallery', compact('tenant', 'company', 'hero', 'galleries'));
    }

    public function updates()
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'updates');
        $hero    = $masters->firstWhere('name', 'hero');
        $posts   = Post::where('tenant_id', $tenant->id)->where('status', 1)->latest()->take(12)->get();

        return view('frontend.updates', compact('hero', 'posts'));
    }

    public function updatesDetail($slug)
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'updates');
        $hero    = $masters->firstWhere('name', 'hero');
        $post    = Post::where('tenant_id', $tenant->id)->where('slug', $slug)->where('status', 1)->firstOrFail();
        $recent  = Post::where('tenant_id', $tenant->id)->where('status', 1)->where('id', '!=', $post->id)->latest()->take(10)->get();

        return view('frontend.update_detail', compact('tenant', 'company', 'hero', 'post', 'recent'));
    }

    public function privacyPolicy()
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'other');
        $hero    = $masters->firstWhere('name', 'hero');

        return view('frontend.privacy_policy', compact('tenant', 'company', 'hero'));
    }

    public function termsAndConditions()
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'other');
        $hero    = $masters->firstWhere('name', 'hero');

        return view('frontend.terms_and_conditions', compact('tenant', 'company', 'hero'));
    }

    public function faq()
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'other');
        $hero    = $masters->firstWhere('name', 'hero');
        $faqs    = Faq::where('tenant_id', $tenant->id)->where('status', 1)->orderBy('serial')->get();

        return view('frontend.faq', compact('tenant', 'company', 'hero', 'faqs'));
    }

    public function contact()
    {
        $tenant  = $this->getTenant();
        $company = $this->getCompany($tenant->id);
        $masters = $this->getMaster($tenant->id, 'contact');
        $hero    = $masters->firstWhere('name', 'hero');

        return view('frontend.contact', compact('tenant', 'company', 'hero'));
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