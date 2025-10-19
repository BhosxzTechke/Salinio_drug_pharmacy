<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin:0; padding:24px; background:#f3f4f6; font-family: 'Segoe UI','Roboto',Arial,sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>
      <td align="center">
        <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background:#ffffff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.07); overflow:hidden;">
          <tr>
            <td style="padding:32px;">
              <h1 style="font-size:24px; margin:0 0 12px; color:#111827;">Hello!</h1>

              <p style="font-size:16px; line-height:1.6; margin:12px 0; color:#374151;">
                You are receiving this email because we received a password reset request for your account.
              </p>

              <div style="text-align:center; margin:28px 0;">
                <a href="{{ $url }}"
                   style="display:inline-block; padding:14px 28px; background:#2563eb; color:#ffffff; text-decoration:none; border-radius:8px; font-weight:600; font-size:16px;">
                  Reset Password
                </a>
              </div>

              <p style="font-size:14px; line-height:1.6; margin:12px 0; color:#6b7280;">
                This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required.
              </p>

              <p style="font-size:16px; margin-top:24px; color:#374151;">
                Regards,<br>
                <strong>{{ $appName }}</strong>
              </p>

              <div style="margin-top:24px; padding:12px; background:#f9fafb; border-radius:8px; font-size:12px; color:#6b7280;">
                If you're having trouble clicking the "Reset Password" button, copy and paste this URL into your web browser:<br>
                <span style="word-break:break-all;">{{ $url }}</span>
              </div>
            </td>
          </tr>
        </table>
        <div style="font-size:12px; color:#9ca3af; margin-top:12px;">
          © {{ date('Y') }} {{ $appName }}. All rights reserved.
        </div>
      </td>
    </tr>
  </table>
</body>
</html>
