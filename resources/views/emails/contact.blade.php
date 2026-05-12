<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>New Contact Message</title>
    <style>
        body,table,td,a{margin:0;padding:0;border-collapse:collapse;}
        body{font-family:Arial,Helvetica,sans-serif;background:#f8f8f8;}
        img{border:0;height:auto;outline:none;text-decoration:none;}
        a{text-decoration:none;}
    </style>
</head>
<body style="background:#f8f8f8;margin:0;padding:0;">

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f8f8f8;">
    <tr>
        <td align="center" style="padding:20px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width:600px;background:#fff;border-radius:12px;overflow:hidden;">

                {{-- Header --}}
                <tr>
                    <td style="padding:36px 24px;text-align:center;background:#1a1a1a;">
                        @if($company?->company_logo)
                            <img src="{{ url('uploads/company/' . $company->company_logo) }}"
                                 alt="{{ $company?->company_name }}"
                                 style="max-height:55px;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;">
                        @endif
                        <h1 style="margin:0;color:#fff;font-size:20px;font-weight:700;">{{ $company?->company_name ?? 'New Message' }}</h1>
                        <p style="margin:6px 0 0;color:rgba(255,255,255,.75);font-size:13px;">New contact form submission</p>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding:32px 28px;">

                        <p style="margin:0 0 24px;font-size:15px;color:#444;line-height:1.6;">
                            You have received a new message from your website contact form.
                        </p>

                        {{-- Name --}}
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:16px;border:1px solid #eee;border-radius:8px;overflow:hidden;">
                            <tr>
                                <td style="padding:12px 16px;background:#f9f9f9;font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:#888;width:30%;">Name</td>
                                <td style="padding:12px 16px;font-size:15px;color:#222;">{{ $first_name }} {{ $last_name }}</td>
                            </tr>
                        </table>

                        {{-- Email --}}
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:16px;border:1px solid #eee;border-radius:8px;overflow:hidden;">
                            <tr>
                                <td style="padding:12px 16px;background:#f9f9f9;font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:#888;width:30%;">Email</td>
                                <td style="padding:12px 16px;font-size:15px;color:#222;"><a href="mailto:{{ $email }}" style="color:#222;">{{ $email }}</a></td>
                            </tr>
                        </table>

                        @if($phone)
                        {{-- Phone --}}
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:16px;border:1px solid #eee;border-radius:8px;overflow:hidden;">
                            <tr>
                                <td style="padding:12px 16px;background:#f9f9f9;font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:#888;width:30%;">Phone</td>
                                <td style="padding:12px 16px;font-size:15px;color:#222;">{{ $phone }}</td>
                            </tr>
                        </table>
                        @endif

                        @if($subjectText)
                        {{-- Subject --}}
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:16px;border:1px solid #eee;border-radius:8px;overflow:hidden;">
                            <tr>
                                <td style="padding:12px 16px;background:#f9f9f9;font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:#888;width:30%;">Subject</td>
                                <td style="padding:12px 16px;font-size:15px;color:#222;">{{ $subjectText }}</td>
                            </tr>
                        </table>
                        @endif

                        {{-- Message --}}
                        <p style="margin:24px 0 8px;font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:#888;">Message</p>
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #eee;border-radius:8px;overflow:hidden;">
                            <tr>
                                <td style="padding:18px;font-size:15px;color:#333;line-height:1.7;background:#fafafa;">{{ $contactMessage }}</td>
                            </tr>
                        </table>

                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="padding:20px;background:#f8f8f8;text-align:center;font-size:12px;color:#999;border-top:1px solid #eee;">
                        <p style="margin:0;">© {{ date('Y') }} {{ $company?->company_name ?? '' }}</p>
                        @if($company?->address1)
                        <p style="margin:4px 0 0;">{{ $company->address1 }}@if($company->address2), {{ $company->address2 }}@endif</p>
                        @endif
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>