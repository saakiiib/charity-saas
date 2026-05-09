<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyDetails;
use Intervention\Image\Facades\Image;

class CompanyDetailsController extends Controller
{
    public function index()
    {
        $data = CompanyDetails::firstOrCreate(['tenant_id' => $this->tenantId()]);
        return view('admin.company.index', compact('data'));
    }

    public function update(Request $request)
    {
        $tenantId = $this->tenantId();
        $data = CompanyDetails::firstOrCreate(['tenant_id' => $tenantId]);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'business_name' => 'nullable|max:255',
            'email1' => 'nullable|email|max:255',
            'email2' => 'nullable|email|max:255',
            'phone1' => 'nullable|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'phone3' => 'nullable|string|max:20',
            'phone4' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'tawkto' => 'nullable|string|max:255',
            'vat_percent' => 'nullable|string|max:255',
            'google_appstore_link' => 'nullable|string|max:255',
            'google_play_link' => 'nullable|string|max:255',
            'footer_link' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:10',
            'google_map' => 'nullable|string',
            'company_reg_number' => 'nullable|string',
            'vat_number' => 'nullable|string',

            'fav_icon' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'company_logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'footer_logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'google_site_verification' => 'nullable|string|max:255',
            'meta_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if (!file_exists(public_path('uploads/company'))) {
            mkdir(public_path('uploads/company'), 0755, true);
        }

        if (!file_exists(public_path('uploads/company/meta'))) {
            mkdir(public_path('uploads/company/meta'), 0755, true);
        }

        if ($request->hasFile('fav_icon')) {
            if ($data->fav_icon && file_exists(public_path('uploads/company/' . $data->fav_icon))) {
                unlink(public_path('uploads/company/' . $data->fav_icon));
            }
            $favIconName = rand(100000, 999999) . '_fav_icon.webp';
            Image::make($request->file('fav_icon'))
                ->resize(64, 64, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 80)
                ->save(public_path('uploads/company/' . $favIconName));
            $data->fav_icon = $favIconName;
        }

        if ($request->hasFile('company_logo')) {
            if ($data->company_logo && file_exists(public_path('uploads/company/' . $data->company_logo))) {
                unlink(public_path('uploads/company/' . $data->company_logo));
            }
            $companyLogoName = rand(100000, 999999) . '_company_logo.webp';
            Image::make($request->file('company_logo'))
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 80)
                ->save(public_path('uploads/company/' . $companyLogoName));
            $data->company_logo = $companyLogoName;
        }

        if ($request->hasFile('footer_logo')) {
            if ($data->footer_logo && file_exists(public_path('uploads/company/' . $data->footer_logo))) {
                unlink(public_path('uploads/company/' . $data->footer_logo));
            }
            $footerLogoName = rand(100000, 999999) . '_footer_logo.webp';
            Image::make($request->file('footer_logo'))
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 80)
                ->save(public_path('uploads/company/' . $footerLogoName));
            $data->footer_logo = $footerLogoName;
        }

        if ($request->hasFile('meta_image')) {

            if ($data->meta_image && file_exists(public_path('uploads/company/meta/' . $data->meta_image))) {
                unlink(public_path('uploads/company/meta/' . $data->meta_image));
            }

            $metaImageName = rand(100000, 999999) . '_meta.webp';

            Image::make($request->file('meta_image'))
                ->resize(1200, 630, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 80)
                ->save(public_path('uploads/company/meta/' . $metaImageName));

            $data->meta_image = $metaImageName;
        }

        $data->company_name = $request->company_name;
        $data->business_name = $request->business_name;
        $data->email1 = $request->email1;
        $data->email2 = $request->email2;
        $data->phone1 = $request->phone1;
        $data->phone2 = $request->phone2;
        $data->phone3 = $request->phone3;
        $data->phone4 = $request->phone4;
        $data->whatsapp = $request->whatsapp;
        $data->address1 = $request->address1;
        $data->address2 = $request->address2;
        $data->website = $request->website;
        $data->facebook = $request->facebook;
        $data->instagram = $request->instagram;
        $data->twitter = $request->twitter;
        $data->linkedin = $request->linkedin;
        $data->youtube = $request->youtube;
        $data->tawkto = $request->tawkto;
        $data->vat_percent = $request->vat_percent;
        $data->google_appstore_link = $request->google_appstore_link;
        $data->google_play_link = $request->google_play_link;
        $data->footer_link = $request->footer_link;
        $data->currency = $request->currency;
        $data->footer_content = $request->footer_content;
        $data->google_map = $request->google_map;
        $data->company_reg_number = $request->company_reg_number;
        $data->vat_number = $request->vat_number;
        $data->opening_time = $request->opening_time;
        $data->account_number = $request->account_number;
        $data->sort_code = $request->sort_code;
        $data->bank = $request->bank;

        $data->meta_title = $request->meta_title;
        $data->meta_description = $request->meta_description;
        $data->meta_keywords = $request->meta_keywords;
        $data->google_site_verification = $request->google_site_verification;

        $data->save();

        return redirect()->back()->with('success', 'Company details updated successfully.');
    }
}