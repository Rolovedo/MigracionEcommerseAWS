<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style type="text/css">
            body {
                margin: 0;
                padding: 0;
                background-color: #ffffff;
                font-family: 'Inter', Arial, sans-serif;
                color: #5B3722;
            }

            a {
                color: #8B5E3C;
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>

    <body>
        <div style="max-width: 640px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <!-- Email Background Wrapper -->
            <div style="background-color: #f8f4ec; padding: 40px 30px;">
                <!-- Email Header -->
                <div style="text-align: center; background-color: #ffffff; padding: 20px; border-radius: 8px 8px 0 0; border-bottom: 3px solid #eee1d2; margin-bottom: 30px;">
                    <a href="{{ route('shop.home.index') }}">
                        @if ($logo = core()->getCurrentChannel()->logo_url)
                            <img
                                src="{{ $logo }}"
                                alt="{{ config('app.name') }}"
                                style="height: 45px; max-width: 180px;"
                            />
                        @else
                            <img
                                src="{{ bagisto_asset('images/logo.svg', 'shop') }}"
                                alt="{{ config('app.name') }}"
                                width="131"
                                height="29"
                                style="height: 45px; max-width: 180px;"
                            />
                        @endif
                    </a>
                </div>

                <!-- Email Content Container -->
                <div style="background-color: #ffffff; padding: 30px; border-radius: 0 0 8px 8px; color: #5B3722;">
                    <!-- Email Content -->
                    {{ $slot }}

                    <!-- Email Footer -->
                    <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee1d2;">
                        <p style="font-size: 16px; color: #734A2E; line-height: 24px;">
                            @lang('shop::app.emails.thanks', [
                                'link' => 'mailto:' . core()->getContactEmailDetails()['email'],
                                'email' => core()->getContactEmailDetails()['email'],
                                'style' => 'color: #8B5E3C; font-weight: 500; text-decoration: underline;'
                            ])
                        </p>

                        <div style="text-align: center; margin-top: 30px; font-size: 12px; color: #8B5E3C;">
                            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>