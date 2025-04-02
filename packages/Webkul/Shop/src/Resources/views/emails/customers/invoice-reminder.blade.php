@component('shop::emails.layout')
    <div style="margin-bottom: 34px; font-family: Arial, sans-serif;">
        <p style="font-weight: bold; font-size: 22px; color: #5B3722; line-height: 28px; margin-bottom: 20px;">
            @lang('shop::app.emails.dear', ['customer_name' => $invoice->order->customer_full_name]), 👋
        </p>
    </div>

    <div>
        <p style="font-size: 16px; color: #8B5E3C; line-height: 24px;">
            @lang('shop::app.emails.customers.reminder.invoice-overdue')
        </p>

        <p style="margin-top: 20px; font-size: 16px; color: #8B5E3C; line-height: 24px;">
            @lang('shop::app.emails.customers.reminder.already-paid')
        </p>
    </div>
@endcomponent
