@component('shop::emails.layout')
    <div style="margin-bottom: 34px; font-family: Arial, sans-serif;">
        <p style="font-weight: bold; font-size: 22px; color: #5B3722; line-height: 28px; margin-bottom: 20px;">
            @lang('shop::app.emails.dear', ['customer_name' => $customerNote->customer->name]), 👋
        </p>
    </div>

    <p style="font-size: 16px; color: #8B5E3C; line-height: 24px; margin-bottom: 30px;">
        @lang('shop::app.emails.customers.commented.description', ['note' => $customerNote->note]),
    </p>
@endcomponent
