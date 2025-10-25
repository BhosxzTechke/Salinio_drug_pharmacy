{{-- resources/views/emails/contact-inline.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
</head>
<body style="background:#f3f4f6;margin:0;padding:24px;font-family:system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial;font-size:15px;color:#111827;">
  <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;margin:0 auto;">
          <tr>
            <td style="background:#ffffff;border-radius:16px;box-shadow:0 6px 18px rgba(15,23,42,0.06);overflow:hidden;">
              
              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td style="padding:20px;border-bottom:1px solid #eef2ff;">
                    <table cellpadding="0" cellspacing="0" role="presentation">
                      <tr>
                        <td style="vertical-align:middle;padding-right:12px;">
                          <div style="width:44px;height:44px;border-radius:22px;background:#eef2ff;display:inline-flex;align-items:center;justify-content:center;">
                            <!-- icon -->
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="color:#4f46e5" xmlns="http://www.w3.org/2000/svg">
                              <path d="M16 12H8m0 0l4-4m-4 4l4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                        </td>
                        <td style="vertical-align:middle;">
                          <div style="font-size:13px;color:#6b7280;margin-bottom:2px;">New message received</div>
                          <div style="font-size:17px;font-weight:600;color:#0f172a;">{{ $title }}</div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <tr>
                  <td style="padding:20px;">
                    <!-- From block -->
                    <div style="background:#eef2ff;padding:12px;border-radius:10px;margin-bottom:14px;">
                      <div style="font-size:11px;color:#4f46e5;font-weight:600;text-transform:uppercase;letter-spacing:0.02em;">From</div>
                      <div style="margin-top:6px;font-size:14px;font-weight:600;color:#0f172a;">{{ $name }} <span style="font-weight:400;color:#6b7280;">({{ $from }})</span></div>
                    </div>

                    <!-- Message -->
                    <div style="margin-bottom:18px;">
                      <div style="font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.02em;margin-bottom:6px;">Message</div>
                      <div style="font-size:15px;color:#111827;line-height:1.5;">
                        {{ $body }}
                      </div>
                    </div>

                    <!-- Footer -->
                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                      <tr>
                        <td style="font-size:12px;color:#9ca3af;">Sent via Contact Form</td>
                        <td align="right">
                          <a href="mailto:{{ $from }}" style="display:inline-block;padding:9px 14px;border-radius:999px;background:#4f46e5;color:#ffffff;text-decoration:none;font-size:13px;font-weight:600;">Reply</a>
                        </td>
                      </tr>
                    </table>

                  </td>
                </tr>
              </table>

            </td>
          </tr>

          <tr>
            <td style="padding-top:12px;text-align:center;font-size:12px;color:#9ca3af;">
              You’re receiving this because someone submitted your contact form.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
