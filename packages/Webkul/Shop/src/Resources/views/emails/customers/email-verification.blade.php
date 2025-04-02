@component('shop::emails.layout')
    <div style="margin-bottom: 34px; font-family: Arial, sans-serif;">
        <p style="font-weight: bold; font-size: 22px; color: #5B3722; line-height: 28px; margin-bottom: 20px;">
            @lang('shop::app.emails.dear', ['customer_name' => $customer->name]), 👋
        </p>

        <p style="font-size: 16px; color: #8B5E3C; line-height: 24px;">
            @lang('shop::app.emails.customers.verification.greeting')
        </p>
    </div>

    <p style="font-size: 16px; color: #8B5E3C; line-height: 24px; margin-bottom: 30px;">
        @lang('shop::app.emails.customers.verification.description')
    </p>

    <div style="display: flex; justify-content: center; margin-bottom: 80px;">
        <a
            href="{{ route('shop.customers.verify', $customer->token) }}"
            style="padding: 14px 40px; border-radius: 5px; background: #8B5E3C; color: #FFFFFF; text-decoration: none; text-transform: uppercase; font-weight: bold; font-size: 14px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); transition: background 0.3s;"
            onmouseover="this.style.background='#734A2E'"
            onmouseout="this.style.background='#8B5E3C'"
        >
            @lang('shop::app.emails.customers.verification.verify-email')
        </a>
    </div>
@endcomponent
