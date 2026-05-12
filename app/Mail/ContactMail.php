<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\Tenant;
use App\Models\CompanyDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $tenant;
    public $company;

    public function __construct(Contact $contact, Tenant $tenant, ?CompanyDetails $company)
    {
        $this->contact = $contact;
        $this->tenant  = $tenant;
        $this->company = $company;
    }

    public function build()
    {
        return $this->subject('New Contact — ' . ($this->company?->company_name ?? 'Website'))
                    ->view('emails.contact')
                    ->with([
                        'first_name'     => $this->contact->first_name,
                        'last_name'      => $this->contact->last_name,
                        'email'          => $this->contact->email,
                        'phone'          => $this->contact->phone,
                        'subjectText'    => $this->contact->subject ?? 'New query from website',
                        'contactMessage' => $this->contact->message,
                        'company'        => $this->company,
                    ]);
    }
}