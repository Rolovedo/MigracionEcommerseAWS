@component('shop::emails.layout')
    <div style="margin-bottom: 34px; font-family: Arial, sans-serif;">
        <p style="font-weight: bold; font-size: 22px; color: #5B3722; line-height: 28px; margin-bottom: 20px;">
            @lang('shop::app.emails.dear', ['customer_name' => $customer->name]), 👋
        </p>

        <p style="font-size: 16px; color: #8B5E3C; line-height: 24px;">
            @lang('shop::app.emails.customers.update-password.greeting')
        </p>
    </div>

    <p style="font-size: 16px; color: #8B5E3C; line-height: 24px; margin-bottom: 40px;">
        @lang('shop::app.emails.customers.update-password.description')
    </p>
@endcomponent
