<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <title>New Contact Message</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="color-scheme" content="light dark">
  <meta name="supported-color-schemes" content="light dark">
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings xmlns:o="urn:schemas-microsoft-com:office:office">
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    /* Mobile */
    @media screen and (max-width: 600px){
      .container{ width:100% !important; }
      .px-32{ padding-left:16px !important; padding-right:16px !important; }
      .py-32{ padding-top:20px !important; padding-bottom:20px !important; }
      .h1{ font-size:22px !important; line-height:28px !important; }
      .h2{ font-size:18px !important; line-height:24px !important; }
      .stack td{ display:block !important; width:100% !important; }
    }
    /* Dark mode */
    @media (prefers-color-scheme: dark){
      body, .bg-body{ background:#24456E !important; }
      .card{ background:#24456E !important; border-color:#3b5b86 !important; }
      .text-muted{ color:#ffffff !important; }
      .text-body{ color:#ffffff !important; }
    }
  </style>
</head>
<body style="margin:0; padding:0; background:#24456E; color:#ffffff;" class="bg-body">
  <!-- Preheader (hidden) -->
  <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:#ffffff;">
    New contact message from {{ $name ?? 'a visitor' }} via oncbrothers.com
  </div>

  <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#24456E;">
    <tr>
      <td align="center">

        <!-- Wrapper -->
        <table role="presentation" cellpadding="0" cellspacing="0" width="600" class="container" style="width:600px; max-width:600px; margin:0 auto;">
          <!-- Header / Brand -->
          <tr>
            <td style="background:#24456E;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="px-32 py-32" style="padding:28px 32px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                      <tr class="stack">
                        <td align="left" style="vertical-align:middle;">
                          <!-- Logo (text fallback) -->
                          <a href="{{ url('/') }}" style="text-decoration:none; font-family:Arial,Helvetica,sans-serif; font-weight:700; font-size:22px; color:#ffffff;">
                            ONC<span style="color:#f8951e;">Brothers</span>
                          </a>
                        </td>
                        <td align="right" style="vertical-align:middle;">
                          <span style="font-family:Arial,Helvetica,sans-serif; color:#ffffff; font-size:14px;">
                            Discussions on Current &amp; New Treatments of Cancer
                          </span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <!-- Accent bar -->
                <tr>
                  <td style="height:4px; line-height:4px; background:#f8951e;">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Hero headline -->
          <tr>
            <td style="background:#24456E;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="px-32" style="padding:18px 32px 28px 32px;">
                    <h1 class="h1" style="margin:0; font-family:Arial,Helvetica,sans-serif; font-weight:700; font-size:24px; line-height:32px; color:#ffffff;">
                      New Contact Message
                    </h1>
                    <p style="margin:8px 0 0; font-family:Arial,Helvetica,sans-serif; color:#ffffff; font-size:14px; line-height:20px;">
                      Someone just reached out via the website contact form.
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Message Card -->
          <tr>
            <td class="px-32 py-32" style="padding:24px 32px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="card"
                     style="background:#24456E; border:1px solid #3b5b86; border-radius:12px;">
                <tr>
                  <td style="padding:24px 24px 8px 24px;">
                    <h2 class="h2" style="margin:0 0 8px; font-family:Arial,Helvetica,sans-serif; font-weight:700; font-size:20px; line-height:26px; color:#ffffff;">
                      Message Summary
                    </h2>
                    <p class="text-muted" style="margin:0; font-family:Arial,Helvetica,sans-serif; color:#ffffff; font-size:14px;">
                      Submitted on {{ now()->format('F j, Y g:i A') }}
                    </p>
                  </td>
                </tr>

                <!-- Details -->
                <tr>
                  <td style="padding:8px 24px 0 24px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                      <tr class="stack">
                        <td style="padding:8px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#ffffff; width:34%;"><strong>Name</strong></td>
                        <td style="padding:8px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#ffffff;">{{ $name ?? '—' }}</td>
                      </tr>
                      <tr class="stack">
                        <td style="padding:8px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#ffffff;"><strong>Email</strong></td>
                        <td style="padding:8px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#ffffff;">
                          <a href="mailto:{{ $email ?? '' }}" style="color:#ffffff; text-decoration:none;">{{ $email ?? '—' }}</a>
                        </td>
                      </tr>
                      <tr class="stack">
                        <td style="padding:8px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#ffffff;"><strong>Phone</strong></td>
                        <td style="padding:8px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#ffffff;">{{ $phone ?? '—' }}</td>
                      </tr>
                      <tr class="stack">
                        <td style="padding:8px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#ffffff;"><strong>Address</strong></td>
                        <td style="padding:8px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#ffffff;">{{ $address ?? '—' }}</td>
                      </tr>
                      <tr class="stack">
                        <td style="padding:8px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#ffffff;"><strong>Subject</strong></td>
                        <td style="padding:8px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#ffffff;">{{ $subject ?? '—' }}</td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <!-- Message Body -->
                <tr>
                  <td style="padding:16px 24px 8px 24px;">
                    <div style="background:#24456E; border:1px solid #3b5b86; border-radius:10px; padding:16px;">
                      <p class="text-body" style="margin:0; font-family:Arial,Helvetica,sans-serif; color:#ffffff; font-size:15px; line-height:22px; white-space:pre-line;">
                        {{ $content ?? '—' }}
                      </p>
                    </div>
                  </td>
                </tr>

                <!-- CTA Button -->
                <tr>
                  <td align="center" style="padding:20px 24px 28px;">
                    <!--[if mso]>
                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word"
                      href="mailto:{{ $email ?? '' }}?subject=Re:%20{{ rawurlencode($subject ?? 'Your%20Inquiry') }}"
                      style="height:44px;v-text-anchor:middle;width:220px;" arcsize="50%" stroke="f" fillcolor="#f8951e">
                      <w:anchorlock/>
                      <center style="color:#ffffff;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:bold;">
                        Reply Now
                      </center>
                    </v:roundrect>
                    <![endif]-->
                    <a href="mailto:{{ $email ?? '' }}?subject=Re:%20{{ rawurlencode($subject ?? 'Your Inquiry') }}"
                       style="background:#f8951e; border-radius:999px; color:#ffffff; display:inline-block; font-family:Arial,Helvetica,sans-serif; font-size:16px; font-weight:bold; line-height:44px; text-align:center; text-decoration:none; width:220px; mso-hide:all;">
                      Reply Now
                    </a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:0 32px 28px 32px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                     style="background:#24456E; border-radius:12px;">
                <tr>
                  <td style="padding:18px 20px; text-align:center;">
                    <p style="margin:0; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#ffffff;">
                      © {{ date('Y') }} Oncology Brothers. All rights reserved.
                    </p>
                    <p style="margin:6px 0 0; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#ffffff;">
                      <a href="mailto:info@oncbrothers.com" style="color:#ffffff; text-decoration:none;">info@oncbrothers.com</a>
                      &nbsp;•&nbsp;
                      <a href="{{ url('/') }}" style="color:#ffffff; text-decoration:none;">oncbrothers.com</a>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td style="height:4px; line-height:4px; background:#f8951e; border-bottom-left-radius:12px; border-bottom-right-radius:12px;">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>

        </table>
        <!-- /Wrapper -->

      </td>
    </tr>
  </table>
</body>
</html>
