<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f9f9f9;
            padding: 20px 0;
        }
        .email-content {
            max-width: 600px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-header img {
            width: 150px;
        }
        .email-body {
            font-size: 16px;
            color: #333333;
        }
        .email-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777777;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <table class="email-content" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td class="email-header">
                    <img src="{{ asset('images/logo_bt.png') }}" alt="Logo">
                </td>
            </tr>
            <tr>
                <td class="email-body" align="center">
                    <h1>Reset Your Password</h1>
                </td>
            </tr>
            <tr>
                <td class="email-body" align="center">
                    <p>You are receiving this email because we received a password reset request for your account.</p>
                </td>
            </tr>
            <tr>
                <td class="email-body" align="center">
                    <a href="{{ $url }}" class="btn">Reset Password</a>
                </td>
            </tr>
            <tr>
                <td class="email-body" align="center">
                    <p>If you did not request a password reset, no further action is required.</p>
                </td>
            </tr>
            <tr>
                <td class="email-footer">
                    <p>Thanks,<br>{{ config('app.name') }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
