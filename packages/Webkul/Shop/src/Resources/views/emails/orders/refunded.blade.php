@component('shop::emails.layout')
    <div style="margin-bottom: 34px; background-color: #f8f4ec; padding: 25px; border-radius: 8px;">
        <span style="font-size: 24px; font-weight: 600; color: #8B5E3C; display: block; margin-bottom: 15px;">
            @lang('shop::app.emails.orders.refunded.title')
        </span>

        <p style="font-size: 16px; color: #734A2E; line-height: 24px;">
            @lang('shop::app.emails.dear', ['customer_name' => $refund->order->customer_full_name]),👋
        </p>

        <p style="font-size: 16px; color: #734A2E; line-height: 24px;">
            @lang('shop::app.emails.orders.refunded.greeting', [
                'invoice_id' => $refund->increment_id,
                'order_id'   => '<a href="' . route('shop.customers.account.orders.view', $refund->order_id) . '" style="color: #B8825B; font-weight: 600; text-decoration: none;">#' . $refund->order->increment_id . '</a>',
                'created_at' => core()->formatDate($refund->order->created_at, 'Y-m-d H:i:s')
            ])
        </p>
    </div>

    <div style="font-size: 20px; font-weight: 600; color: #8B5E3C; background-color: #eee1d2; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
        @lang('shop::app.emails.orders.refunded.summary')
    </div>

    <div style="display: flex; flex-direction: row; margin-top: 20px; justify-content: space-between; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
        @if ($refund->order->shipping_address)
            <div style="line-height: 25px; background-color: #F4E8E0; padding: 20px; border-radius: 8px; flex: 1; min-width: 300px;">
                <div style="font-size: 16px; font-weight: 600; color: #8B5E3C; border-bottom: 2px solid #C99D7B; padding-bottom: 8px; margin-bottom: 12px;">
                    @lang('shop::app.emails.orders.shipping-address')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #5B3722; margin-bottom: 25px;">
                    {{ $refund->order->shipping_address->company_name ?? '' }}<br/>

                    {{ $refund->order->shipping_address->name }}<br/>

                    {{ $refund->order->shipping_address->address }}<br/>

                    {{ $refund->order->shipping_address->postcode . " " . $refund->order->shipping_address->city }}<br/>

                    {{ $refund->order->shipping_address->state }}<br/>

                    <div style="margin: 15px 0; border-top: 1px dashed #C99D7B;"></div>

                    <span style="color: #8B5E3C; font-weight: 500;">@lang('shop::app.emails.orders.contact'):</span> {{ $refund->order->billing_address->phone }}
                </div>

                <div style="font-size: 16px; font-weight: 600; color: #8B5E3C; border-bottom: 2px solid #C99D7B; padding-bottom: 8px; margin-bottom: 12px;">
                    @lang('shop::app.emails.orders.shipping')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #5B3722; padding: 5px 0;">
                    {{ $refund->order->shipping_title }}
                </div>
            </div>
        @endif

        @if ($refund->order->billing_address)
            <div style="line-height: 25px; background-color: #F4E8E0; padding: 20px; border-radius: 8px; flex: 1; min-width: 300px;">
                <div style="font-size: 16px; font-weight: 600; color: #8B5E3C; border-bottom: 2px solid #C99D7B; padding-bottom: 8px; margin-bottom: 12px;">
                    @lang('shop::app.emails.orders.billing-address')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #5B3722; margin-bottom: 25px;">
                    {{ $refund->order->billing_address->company_name ?? '' }}<br/>

                    {{ $refund->order->billing_address->name }}<br/>

                    {{ $refund->order->billing_address->address }}<br/>

                    {{ $refund->order->billing_address->postcode . " " . $refund->order->billing_address->city }}<br/>

                    {{ $refund->order->billing_address->state }}<br/>

                    <div style="margin: 15px 0; border-top: 1px dashed #C99D7B;"></div>

                    <span style="color: #8B5E3C; font-weight: 500;">@lang('shop::app.emails.orders.contact'):</span> {{ $refund->order->billing_address->phone }}
                </div>

                <div style="font-size: 16px; font-weight: 600; color: #8B5E3C; border-bottom: 2px solid #C99D7B; padding-bottom: 8px; margin-bottom: 12px;">
                    @lang('shop::app.emails.orders.payment')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #5B3722; padding: 5px 0;">
                    {{ core()->getConfigData('sales.payment_methods.' . $refund->order->payment->method . '.title') }}
                </div>

                @php $additionalDetails = \Webkul\Payment\Payment::getAdditionalDetails($refund->order->payment->method); @endphp

                @if (! empty($additionalDetails))
                    <div style="font-size: 16px; color: #5B3722; margin-top: 10px;">
                        <div style="font-weight: 500;">{{ $additionalDetails['title'] }}</div>
                        <div>{{ $additionalDetails['value'] }}</div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <div style="padding-bottom: 40px; border-bottom: 1px solid #C99D7B; margin-bottom: 30px;">
        <table style="overflow-x: auto; border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr style="background-color: #eee1d2;">
                    @foreach (['name', 'price', 'qty'] as $item)
                        <th style="text-align: left; padding: 15px; color: #8B5E3C; font-weight: 600; font-size: 16px; border-bottom: 2px solid #C99D7B;">
                            @lang('shop::app.emails.orders.' . $item)
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody style="font-size: 16px; font-weight: 400; color: #5B3722;">
                @foreach ($refund->items as $item)
                    <tr style="vertical-align: text-top; border-bottom: 1px solid #E8D3C2;">
                        <td style="text-align: left; padding: 15px;">
                            <span style="font-weight: 500; color: #734A2E;">{{ $item->name }}</span>

                            @if (isset($item->additional['attributes']))
                                <div style="margin-top: 8px; font-size: 14px;">
                                    @foreach ($item->additional['attributes'] as $attribute)
                                        <b>{{ $attribute['attribute_name'] }}: </b>{{ $attribute['option_label'] }}</br>
                                    @endforeach
                                </div>
                            @endif
                        </td>

                        <td style="text-align: left; padding: 15px;">
                            @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                <span style="font-weight: 500; color: #734A2E;">{{ core()->formatPrice($item->price_incl_tax, $refund->order_currency_code) }}</span>
                            @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                <span style="font-weight: 500; color: #734A2E;">{{ core()->formatPrice($item->price_incl_tax, $refund->order_currency_code) }}</span>

                                <div style="font-size: 12px; white-space: nowrap; margin-top: 4px; color: #8B5E3C;">
                                    @lang('shop::app.emails.orders.excl-tax')

                                    <span style="font-weight: 600;">
                                        {{ core()->formatPrice($item->price, $refund->order_currency_code) }}
                                    </span>
                                </div>
                            @else
                                <span style="font-weight: 500; color: #734A2E;">{{ core()->formatPrice($item->price, $refund->order_currency_code) }}</span>
                            @endif
                        </td>

                        <td style="text-align: left; padding: 15px;">
                            {{ $item->qty }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="background-color: #f8f4ec; border-radius: 8px; padding: 20px; font-size: 16px; color: #5B3722; line-height: 30px; margin-bottom: 30px;">
        <div style="display: grid; width: 100%; max-width: 400px; margin-left: auto;">
            @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
                <div style="display: grid; gap: 10px; grid-template-columns: 1fr auto; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #E8D3C2;">
                    <span style="color: #734A2E;">
                        @lang('shop::app.emails.orders.subtotal')
                    </span>

                    <span style="text-align: right; font-weight: 500;">
                        {{ core()->formatPrice($refund->sub_total, $refund->order_currency_code_incl_tax) }}
                    </span>
                </div>
            @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
                <div style="display: grid; gap: 10px; grid-template-columns: 1fr auto; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #E8D3C2;">
                    <span style="color: #734A2E;">
                        @lang('shop::app.emails.orders.subtotal-excl-tax')
                    </span>

                    <span style="text-align: right; font-weight: 500;">
                        {{ core()->formatPrice($refund->sub_total, $refund->order_currency_code) }}
                    </span>
                </div>

                <div style="display: grid; gap: 10px; grid-template-columns: 1fr auto; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #E8D3C2;">
                    <span style="color: #734A2E;">
                        @lang('shop::app.emails.orders.subtotal-incl-tax')
                    </span>

                    <span style="text-align: right; font-weight: 500;">
                        {{ core()->formatPrice($refund->sub_total, $refund->order_currency_code_incl_tax) }}
                    </span>
                </div>
            @else
                <div style="display: grid; gap: 10px; grid-template-columns: 1fr auto; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #E8D3C2;">
                    <span style="color: #734A2E;">
                        @lang('shop::app.emails.orders.subtotal')
                    </span>

                    <span style="text-align: right; font-weight: 500;">
                        {{ core()->formatPrice($refund->sub_total, $refund->order_currency_code) }}
                    </span>
                </div>
            @endif

            @if ($refund->order->shipping_address)
                @if (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'including_tax')
                    <div style="display: grid; gap: 10px; grid-template-columns: 1fr auto; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #E8D3C2;">
                        <span style="color: #734A2E;">
                            @lang('shop::app.emails.orders.shipping-handling')
                        </span>

                        <span style="text-align: right; font-weight: 500;">
                            {{ core()->formatPrice($refund->shipping_amount_incl_tax, $refund->order_currency_code) }}
                        </span>
                    </div>
                @elseif (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'both')
                    <div style="display: grid; gap: 10px; grid-template-columns: 1fr auto; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #E8D3C2;">
                        <span style="color: #734A2E;">
                            @lang('shop::app.emails.orders.shipping-handling-excl-tax')
                        </span>

                        <span style="text-align: right; font-weight: 500;">
                            {{ core()->formatPrice($refund->shipping_amount, $refund->order_currency_code) }}
                        </span>
                    </div>

                    <div style="display: grid; gap: 10px; grid-template-columns: 1fr auto; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #E8D3C2;">
                        <span style="color: #734A2E;">
                            @lang('shop::app.emails.orders.shipping-handling-incl-tax')
                        </span>

                        <span style="text-align: right; font-weight: 500;">
                            {{ core()->formatPrice($refund->shipping_amount_incl_tax, $refund->order_currency_code) }}
                        </span>
                    </div>
                @else
                    <div style="display: grid; gap: 10px; grid-template-columns: 1fr auto; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #E8D3C2;">
                        <span style="color: #734A2E;">
                            @lang('shop::app.emails.orders.shipping-handling')
                        </span>

                        <span style="text-align: right; font-weight: 500;">
                            {{ core()->formatPrice($refund->shipping_amount, $refund->order_currency_code) }}
                        </span>
                    </div>
                @endif
            @endif

            <div style="display: grid; gap: 10px; grid-template-columns: 1fr auto; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #E8D3C2;">
                <span style="color: #734A2E;">
                    @lang('shop::app.emails.orders.tax')
                </span>

                <span style="text-align: right; font-weight: 500;">
                    {{ core()->formatPrice($refund->tax_amount, $refund->order_currency_code) }}
                </span>
            </div>

            @if ($refund->discount_amount > 0)
                <div style="display: grid; gap: 10px; grid-template-columns: 1fr auto; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #E8D3C2;">
                    <span style="color: #734A2E;">
                        @lang('shop::app.emails.orders.discount')
                    </span>

                    <span style="text-align: right; font-weight: 500;">
                        {{ core()->formatPrice($refund->discount_amount, $refund->order_currency_code) }}
                    </span>
                </div>
            @endif

            <div style="display: grid; gap: 10px; grid-template-columns: 1fr auto; margin-top: 15px; padding-top: 15px; border-top: 2px solid #C99D7B;">
                <span style="color: #8B5E3C; font-weight: 600; font-size: 18px;">
                    @lang('shop::app.emails.orders.grand-total')
                </span>

                <span style="text-align: right; font-weight: 700; font-size: 18px; color: #8B5E3C;">
                    {{ core()->formatPrice($refund->grand_total, $refund->order_currency_code) }}
                </span>
            </div>
        </div>
    </div>

    <div style="background-color: #eee1d2; text-align: center; padding: 15px; border-radius: 8px; color: #734A2E; font-size: 14px;">
        ¡Gracias por su preferencia! Si tiene alguna pregunta, no dude en contactarnos.
    </div>
@endcomponent