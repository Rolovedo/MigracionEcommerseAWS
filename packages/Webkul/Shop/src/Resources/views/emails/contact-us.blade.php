@component('shop::emails.layout')
    <div style="margin-bottom: 34px; background-color: #f8f4ec; padding: 25px; border-radius: 8px;">
        <div style="font-size: 24px; font-weight: 600; color: #8B5E3C; margin-bottom: 20px;">
            @lang('shop::app.emails.contact-us.title', ['shop_title' => config('app.name')])
        </div>

        <p style="font-size: 16px; color: #5B3722; line-height: 24px; background-color: #F4E8E0; padding: 20px; border-radius: 6px; border-left: 4px solid #8B5E3C;">
            {{ $contactUs['message'] }}
        </p>
    </div>

    <div style="font-size: 16px; color: #5B3722; line-height: 24px; margin-bottom: 40px; background-color: #eee1d2; padding: 20px; border-radius: 8px;">
        <p style="margin-bottom: 15px;">
            @lang('shop::app.emails.contact-us.to')

            <a href="mailto:{{ $contactUs['email'] }}" style="color: #8B5E3C; font-weight: 600; text-decoration: underline;">{{ $contactUs['email'] }}</a>,
        </p>

        <p style="margin-bottom: 15px;">
            @lang('shop::app.emails.contact-us.reply-to-mail')
        </p>

        @if($contactUs['contact'])
            <p style="margin-bottom: 0;">
                @lang('shop::app.emails.contact-us.reach-via-phone')

                <a href="tel:{{ $contactUs['contact'] }}" style="color: #8B5E3C; font-weight: 600; text-decoration: underline;">{{ $contactUs['contact'] }}</a>
            </p>
        @endif
    </div>

    <div style="text-align: center; padding: 20px; background-color: #f8f4ec; border-radius: 8px; border-top: 2px solid #eee1d2;">
        <p style="color: #8B5E3C; font-size: 14px; margin: 0;">
            © {{ date('Y') }} {{ config('app.name') }}. @lang('shop::app.emails.contact-us.all-rights-reserved')
        </p>
    </div>
@endcomponent