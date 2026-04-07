<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email</title>
</head>

<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f6fb;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:20px;">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#007BFF; padding:20px; text-align:center; color:#ffffff;">
                            <h2 style="margin:0;">Overseas Education Lane</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333; font-size:16px; line-height:1.6;">
                            
                            {!! $email_body !!}
                            
                        </td>
                    </tr>

                    <!-- Button -->
                   <tr>
                        <td align="center" style="padding-bottom:30px;">
                            <a href="https://www.overseaseducationlane.com/" 
                            style="background:#007BFF; color:#ffffff; padding:12px 25px; text-decoration:none; border-radius:5px; font-weight:bold;">
                            {{ 'View Details' }}
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#eef2ff; padding:15px; text-align:center; font-size:12px; color:#666;">
                            <p style="margin:0;">© {{ date('Y') }} Your Company. All rights reserved.</p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>