@component('shop::emails.layout')
    <div style="background-color: #f8f4ec; padding: 30px; border-radius: 10px; margin-bottom: 34px;">
        <span style="font-size: 24px; font-weight: 600; color: #5B3722; display: block; margin-bottom: 15px; border-bottom: 2px solid #eee1d2; padding-bottom: 10px;">
            @lang('shop::app.emails.orders.created.title')
        </span>

        <p style="font-size: 16px; color: #8B5E3C; line-height: 24px;">
            @lang('shop::app.emails.dear', ['customer_name' => $order->customer_full_name]),👋
        </p>

        <p style="font-size: 16px; color: #8B5E3C; line-height: 24px;">
            {!! __('shop::app.emails.orders.created.greeting', [
                'order_id' => '<a href="' . route('shop.customers.account.orders.view', $order->id) . '" style="color: #734A2E; font-weight: 600; text-decoration: none; border-bottom: 1px solid #C99D7B;">#' . $order->increment_id . '</a>',
                'created_at' => core()->formatDate($order->created_at, 'Y-m-d H:i:s')
                ])
            !!}
        </p>
    </div>

    <div style="font-size: 22px; font-weight: 600; color: #5B3722; margin-bottom: 15px; border-left: 4px solid #C99D7B; padding-left: 15px;">
        @lang('shop::app.emails.orders.created.summary')
    </div>

    <div style="display: flex; flex-direction: row; margin-top: 20px; justify-content: space-between; margin-bottom: 40px; gap: 20px; flex-wrap: wrap;">
        @if ($order->shipping_address)
            <div style="line-height: 25px; flex: 1; min-width: 280px; background-color: #F4E8E0; padding: 20px; border-radius: 8px;">
                <div style="font-size: 18px; font-weight: 600; color: #5B3722; margin-bottom: 10px; border-bottom: 1px solid #E8D3C2; padding-bottom: 8px;">
                    @lang('shop::app.emails.orders.shipping-address')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #734A2E; margin-bottom: 25px;">
                    {{ $order->shipping_address->company_name ?? '' }}<br/>

                    {{ $order->shipping_address->name }}<br/>

                    {{ $order->shipping_address->address }}<br/>

                    {{ $order->shipping_address->postcode . " " . $order->shipping_address->city }}<br/>

                    {{ $order->shipping_address->state }}<br/>

                    <div style="margin: 10px 0; border-top: 1px dashed #E8D3C2; padding-top: 10px;"></div>

                    <strong>@lang('shop::app.emails.orders.contact'):</strong> {{ $order->billing_address->phone }}
                </div>

                <div style="font-size: 18px; font-weight: 600; color: #5B3722; margin-bottom: 10px; border-bottom: 1px solid #E8D3C2; padding-bottom: 8px;">
                    @lang('shop::app.emails.orders.shipping')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #734A2E; background-color: #eee1d2; padding: 10px; border-radius: 5px;">
                    {{ $order->shipping_title }}
                </div>
            </div>
        @endif

        @if ($order->billing_address)
            <div style="line-height: 25px; flex: 1; min-width: 280px; background-color: #F4E8E0; padding: 20px; border-radius: 8px;">
                <div style="font-size: 18px; font-weight: 600; color: #5B3722; margin-bottom: 10px; border-bottom: 1px solid #E8D3C2; padding-bottom: 8px;">
                    @lang('shop::app.emails.orders.billing-address')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #734A2E; margin-bottom: 25px;">
                    {{ $order->billing_address->company_name ?? '' }}<br/>

                    {{ $order->billing_address->name }}<br/>

                    {{ $order->billing_address->address }}<br/>

                    {{ $order->billing_address->postcode . " " . $order->billing_address->city }}<br/>

                    {{ $order->billing_address->state }}<br/>

                    <div style="margin: 10px 0; border-top: 1px dashed #E8D3C2; padding-top: 10px;"></div>

                    <strong>@lang('shop::app.emails.orders.contact'):</strong> {{ $order->billing_address->phone }}
                </div>

                <div style="font-size: 18px; font-weight: 600; color: #5B3722; margin-bottom: 10px; border-bottom: 1px solid #E8D3C2; padding-bottom: 8px;">
                    @lang('shop::app.emails.orders.payment')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #734A2E; background-color: #eee1d2; padding: 10px; border-radius: 5px;">
                    {{ core()->getConfigData('sales.payment_methods.' . $order->payment->method . '.title') }}
                </div>

                @php $additionalDetails = \Webkul\Payment\Payment::getAdditionalDetails($order->payment->method); @endphp

                @if (! empty($additionalDetails))
                    <div style="font-size: 16px; color: #734A2E; margin-top: 15px; padding: 10px; background-color: #eee1d2; border-radius: 5px;">
                        <div style="font-weight: 600;">{{ $additionalDetails['title'] }}</div>

                        <div>{{ $additionalDetails['value'] }}</div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <div style="padding-bottom: 40px; border-bottom: 1px solid #E8D3C2;">
        <table style="overflow-x: auto; border-collapse: collapse; border-spacing: 0; width: 100%; border-radius: 8px; overflow: hidden;">
            <thead>
                <tr style="background-color: #D9B89E; color: #5B3722;">
                    @foreach (['sku', 'name', 'price', 'qty'] as $item)
                        <th style="text-align: left; padding: 15px; font-weight: 600;">
                            @lang('shop::app.emails.orders.' . $item)
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody style="font-size: 16px; font-weight: 400; color: #734A2E; background-color: #F4E8E0;">
                @foreach ($order->items as $item)
                    <tr style="vertical-align: text-top; border-bottom: 1px solid #eee1d2;">
                        <td style="text-align: left; padding: 15px;">
                            {{ $item->getTypeInstance()->getOrderedItem($item)->sku }}
                        </td>

                        <td style="text-align: left; padding: 15px;">
                            <div style="font-weight: 600; color: #5B3722;">{{ $item->name }}</div>

                            @if (isset($item->additional['attributes']))
                                <div style="margin-top: 8px;">
                                    @foreach ($item->additional['attributes'] as $attribute)
                                        <div style="margin-bottom: 4px;">
                                            <b style="color: #8B5E3C;">{{ $attribute['attribute_name'] }}: </b>
                                            <span>{{ $attribute['option_label'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </td>

                        <td style="display: flex; flex-direction: column; text-align: left; padding: 15px;">
                            @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                <span style="font-weight: 600; color: #5B3722;">
                                    {{ core()->formatPrice($item->price_incl_tax, $order->order_currency_code) }}
                                </span>
                            @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                <span style="font-weight: 600; color: #5B3722;">
                                    {{ core()->formatPrice($item->price_incl_tax, $order->order_currency_code) }}
                                </span>

                                <span style="font-size: 12px; white-space: nowrap; margin-top: 5px; background-color: #eee1d2; padding: 3px 6px; border-radius: 4px; display: inline-block;">
                                    @lang('shop::app.emails.orders.excl-tax')
                                    <span style="font-weight: 600;">
                                        {{ core()->formatPrice($item->price, $order->order_currency_code) }}
                                    </span>
                                </span>
                            @else
                                <span style="font-weight: 600; color: #5B3722;">
                                    {{ core()->formatPrice($item->price, $order->order_currency_code) }}
                                </span>
                            @endif
                        </td>

                        <td style="text-align: left; padding: 15px; font-weight: 600;">
                            {{ $item->qty_ordered }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="background-color: #F4E8E0; border-radius: 8px; padding: 20px; margin-top: 30px; font-size: 16px; color: #734A2E; line-height: 30px;">
        @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
            <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 8px 0; border-bottom: 1px solid #eee1d2;">
                <span>
                    @lang('shop::app.emails.orders.subtotal')
                </span>

                <span style="text-align: right; font-weight: 600; color: #5B3722;">
                    {{ core()->formatPrice($order->sub_total, $order->order_currency_code_incl_tax) }}
                </span>
            </div>
        @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
            <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 8px 0; border-bottom: 1px solid #eee1d2;">
                <span>
                    @lang('shop::app.emails.orders.subtotal-excl-tax')
                </span>

                <span style="text-align: right; font-weight: 600; color: #5B3722;">
                    {{ core()->formatPrice($order->sub_total, $order->order_currency_code) }}
                </span>
            </div>

            <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 8px 0; border-bottom: 1px solid #eee1d2;">
                <span>
                    @lang('shop::app.emails.orders.subtotal-incl-tax')
                </span>

                <span style="text-align: right; font-weight: 600; color: #5B3722;">
                    {{ core()->formatPrice($order->sub_total, $order->order_currency_code_incl_tax) }}
                </span>
            </div>
        @else
            <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 8px 0; border-bottom: 1px solid #eee1d2;">
                <span>
                    @lang('shop::app.emails.orders.subtotal')
                </span>

                <span style="text-align: right; font-weight: 600; color: #5B3722;">
                    {{ core()->formatPrice($order->sub_total, $order->order_currency_code) }}
                </span>
            </div>
        @endif

        @if ($order->shipping_address)
            @if (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'including_tax')
                <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 8px 0; border-bottom: 1px solid #eee1d2;">
                    <span>
                        @lang('shop::app.emails.orders.shipping-handling')
                    </span>

                    <span style="text-align: right; font-weight: 600; color: #5B3722;">
                        {{ core()->formatPrice($order->shipping_amount_incl_tax, $order->order_currency_code) }}
                    </span>
                </div>
            @elseif (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'both')
                <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 8px 0; border-bottom: 1px solid #eee1d2;">
                    <span>
                        @lang('shop::app.emails.orders.shipping-handling-excl-tax')
                    </span>

                    <span style="text-align: right; font-weight: 600; color: #5B3722;">
                        {{ core()->formatPrice($order->shipping_amount, $order->order_currency_code) }}
                    </span>
                </div>

                <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 8px 0; border-bottom: 1px solid #eee1d2;">
                    <span>
                        @lang('shop::app.emails.orders.shipping-handling-incl-tax')
                    </span>

                    <span style="text-align: right; font-weight: 600; color: #5B3722;">
                        {{ core()->formatPrice($order->shipping_amount_incl_tax, $order->order_currency_code) }}
                    </span>
                </div>
            @else
                <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 8px 0; border-bottom: 1px solid #eee1d2;">
                    <span>
                        @lang('shop::app.emails.orders.shipping-handling')
                    </span>

                    <span style="text-align: right; font-weight: 600; color: #5B3722;">
                        {{ core()->formatPrice($order->shipping_amount, $order->order_currency_code) }}
                    </span>
                </div>
            @endif
        @endif

        <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 8px 0; border-bottom: 1px solid #eee1d2;">
            <span>
                @lang('shop::app.emails.orders.tax')
            </span>

            <span style="text-align: right; font-weight: 600; color: #5B3722;">
                {{ core()->formatPrice($order->tax_amount, $order->order_currency_code) }}
            </span>
        </div>

        @if ($order->discount_amount > 0)
            <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 8px 0; border-bottom: 1px solid #eee1d2;">
                <span>
                    @lang('shop::app.emails.orders.discount')
                </span>

                <span style="text-align: right; font-weight: 600; color: #5B3722;">
                    -{{ core()->formatPrice($order->discount_amount, $order->order_currency_code) }}
                </span>
            </div>
        @endif

        <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 15px 0; margin-top: 10px; border-top: 2px solid #E8D3C2; font-size: 18px; font-weight: 700;">
            <span style="color: #5B3722;">
                @lang('shop::app.emails.orders.grand-total')
            </span>

            <span style="text-align: right; color: #5B3722; background-color: #D9B89E; padding: 5px 15px; border-radius: 5px;">
                {{ core()->formatPrice($order->grand_total, $order->order_currency_code) }}
            </span>
        </div>
    </div>
@endcomponent
