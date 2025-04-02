@component('shop::emails.layout')
    <!-- Header Section -->
    <div style="background-color: #f8f4ec; padding: 30px; border-radius: 8px; margin-bottom: 34px; border-left: 5px solid #8B5E3C;">
        <span style="font-size: 24px; font-weight: 600; color: #5B3722; display: block; margin-bottom: 15px;">
            @lang('shop::app.emails.orders.invoiced.title')
        </span>

        <p style="font-size: 16px; color: #734A2E; line-height: 26px; margin-bottom: 10px;">
            @lang('shop::app.emails.dear', ['customer_name' => $invoice->order->customer_full_name]),👋
        </p>

        <p style="font-size: 16px; color: #734A2E; line-height: 26px;">
            @lang('shop::app.emails.orders.invoiced.greeting', [
                'invoice_id' => $invoice->increment_id,
                'order_id'   => '<a href="' . route('shop.customers.account.orders.view', $invoice->order_id) . '" style="color: #8B5E3C; font-weight: 600; text-decoration: underline;">#' . $invoice->order->increment_id . '</a>',
                'created_at' => core()->formatDate($invoice->order->created_at, 'Y-m-d H:i:s')
            ])
        </p>
    </div>

    <!-- Summary Header -->
    <div style="font-size: 22px; font-weight: 600; color: #5B3722; background-color: #eee1d2; padding: 15px; border-radius: 6px; margin-bottom: 25px;">
        @lang('shop::app.emails.orders.invoiced.summary')
    </div>

    <!-- Address & Shipping Information -->
    <div style="display: flex; flex-direction: row; margin-top: 20px; justify-content: space-between; margin-bottom: 40px;">
        @if ($invoice->order->shipping_address)
            <div style="line-height: 25px; background-color: #F4E8E0; padding: 20px; border-radius: 8px; width: 48%;">
                <div style="font-size: 18px; font-weight: 600; color: #5B3722; border-bottom: 2px solid #D9B89E; padding-bottom: 10px; margin-bottom: 15px;">
                    @lang('shop::app.emails.orders.shipping-address')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #734A2E; margin-bottom: 25px;">
                    {{ $invoice->order->shipping_address->company_name ?? '' }}<br/>
                    {{ $invoice->order->shipping_address->name }}<br/>
                    {{ $invoice->order->shipping_address->address }}<br/>
                    {{ $invoice->order->shipping_address->postcode . " " . $invoice->order->shipping_address->city }}<br/>
                    {{ $invoice->order->shipping_address->state }}<br/>
                    <div style="margin: 10px 0; border-top: 1px dashed #D9B89E; padding-top: 10px;"></div>
                    <strong>@lang('shop::app.emails.orders.contact'):</strong> {{ $invoice->order->billing_address->phone }}
                </div>

                <div style="font-size: 18px; font-weight: 600; color: #5B3722; border-bottom: 2px solid #D9B89E; padding-bottom: 10px; margin-bottom: 15px;">
                    @lang('shop::app.emails.orders.shipping')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #734A2E; background-color: #f8f4ec; padding: 10px; border-radius: 4px;">
                    {{ $invoice->order->shipping_title }}
                </div>
            </div>
        @endif

        @if ($invoice->order->billing_address)
            <div style="line-height: 25px; background-color: #F4E8E0; padding: 20px; border-radius: 8px; width: 48%;">
                <div style="font-size: 18px; font-weight: 600; color: #5B3722; border-bottom: 2px solid #D9B89E; padding-bottom: 10px; margin-bottom: 15px;">
                    @lang('shop::app.emails.orders.billing-address')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #734A2E; margin-bottom: 25px;">
                    {{ $invoice->order->billing_address->company_name ?? '' }}<br/>
                    {{ $invoice->order->billing_address->name }}<br/>
                    {{ $invoice->order->billing_address->address }}<br/>
                    {{ $invoice->order->billing_address->postcode . " " . $invoice->order->billing_address->city }}<br/>
                    {{ $invoice->order->billing_address->state }}<br/>
                    <div style="margin: 10px 0; border-top: 1px dashed #D9B89E; padding-top: 10px;"></div>
                    <strong>@lang('shop::app.emails.orders.contact'):</strong> {{ $invoice->order->billing_address->phone }}
                </div>

                <div style="font-size: 18px; font-weight: 600; color: #5B3722; border-bottom: 2px solid #D9B89E; padding-bottom: 10px; margin-bottom: 15px;">
                    @lang('shop::app.emails.orders.payment')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #734A2E; background-color: #f8f4ec; padding: 10px; border-radius: 4px;">
                    {{ core()->getConfigData('sales.payment_methods.' . $invoice->order->payment->method . '.title') }}
                </div>

                @php $additionalDetails = \Webkul\Payment\Payment::getAdditionalDetails($invoice->order->payment->method); @endphp

                @if (! empty($additionalDetails))
                    <div style="font-size: 16px; color: #734A2E; margin-top: 10px; background-color: #f8f4ec; padding: 10px; border-radius: 4px;">
                        <div style="font-weight: 600;">{{ $additionalDetails['title'] }}</div>
                        <div>{{ $additionalDetails['value'] }}</div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Order Items Table -->
    <div style="padding-bottom: 40px; border-bottom: 2px solid #D9B89E; margin-bottom: 30px;">
        <table style="border-collapse: collapse; border-spacing: 0; width: 100%; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(139, 94, 60, 0.1);">
            <thead>
                <tr style="background-color: #8B5E3C; color: #fff;">
                    @foreach (['sku', 'name', 'price', 'qty'] as $item)
                        <th style="text-align: left; padding: 15px; font-size: 16px;">
                            @lang('shop::app.emails.orders.' .$item)
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody style="font-size: 16px; font-weight: 400; color: #734A2E;">
                @foreach ($invoice->items as $item)
                    <tr style="vertical-align: text-top; border-bottom: 1px solid #eee1d2;">
                        <td style="text-align: left; padding: 15px; background-color: #f8f4ec;">
                            <span style="font-family: monospace; background-color: #F4E8E0; padding: 4px 8px; border-radius: 4px;">{{ $item->getTypeInstance()->getOrderedItem($item)->sku }}</span>
                        </td>

                        <td style="text-align: left; padding: 15px;">
                            <strong>{{ $item->name }}</strong>

                            @if (isset($item->additional['attributes']))
                                <div style="margin-top: 8px; font-size: 14px;">
                                    @foreach ($item->additional['attributes'] as $attribute)
                                        <div style="margin: 3px 0;"><b>{{ $attribute['attribute_name'] }}: </b>{{ $attribute['option_label'] }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </td>

                        <td style="display: flex; flex-direction: column; text-align: left; padding: 15px; background-color: #f8f4ec;">
                            @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                <strong>{{ core()->formatPrice($item->price_incl_tax, $invoice->order_currency_code) }}</strong>
                            @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                <strong>{{ core()->formatPrice($item->price_incl_tax, $invoice->order_currency_code) }}</strong>

                                <span style="font-size: 12px; white-space: nowrap; margin-top: 5px; color: #8B5E3C;">
                                    @lang('shop::app.emails.orders.excl-tax')

                                    <span style="font-weight: 600;">
                                        {{ core()->formatPrice($item->price, $invoice->order_currency_code) }}
                                    </span>
                                </span>
                            @else
                                <strong>{{ core()->formatPrice($item->price, $invoice->order_currency_code) }}</strong>
                            @endif
                        </td>

                        <td style="text-align: center; padding: 15px; font-weight: bold; background-color: #f8f4ec;">
                            <span style="background-color: #eee1d2; padding: 5px 10px; border-radius: 50px; min-width: 30px; display: inline-block;">{{ $item->qty }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Order Summary -->
    <div style="background-color: #f8f4ec; border-radius: 8px; padding: 25px; font-size: 16px; color: #734A2E; line-height: 30px; margin-top: 20px; margin-bottom: 30px;">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #5B3722; border-bottom: 2px solid #D9B89E; padding-bottom: 10px;">Resumen del Pedido</h3>

        @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
            <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-bottom: 10px;">
                <span>
                    @lang('shop::app.emails.orders.subtotal')
                </span>

                <span style="text-align: right; font-weight: 600;">
                    {{ core()->formatPrice($invoice->sub_total, $invoice->order_currency_code_incl_tax) }}
                </span>
            </div>
        @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
            <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-bottom: 10px;">
                <span>
                    @lang('shop::app.emails.orders.subtotal-excl-tax')
                </span>

                <span style="text-align: right; font-weight: 600;">
                    {{ core()->formatPrice($invoice->sub_total, $invoice->order_currency_code) }}
                </span>
            </div>

            <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-bottom: 10px;">
                <span>
                    @lang('shop::app.emails.orders.subtotal-incl-tax')
                </span>

                <span style="text-align: right; font-weight: 600;">
                    {{ core()->formatPrice($invoice->sub_total, $invoice->order_currency_code_incl_tax) }}
                </span>
            </div>
        @else
            <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-bottom: 10px;">
                <span>
                    @lang('shop::app.emails.orders.subtotal')
                </span>

                <span style="text-align: right; font-weight: 600;">
                    {{ core()->formatPrice($invoice->sub_total, $invoice->order_currency_code) }}
                </span>
            </div>
        @endif

        @if ($invoice->order->shipping_address)
            @if (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'including_tax')
                <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-bottom: 10px;">
                    <span>
                        @lang('shop::app.emails.orders.shipping-handling')
                    </span>

                    <span style="text-align: right; font-weight: 600;">
                        {{ core()->formatPrice($invoice->shipping_amount_incl_tax, $invoice->order_currency_code) }}
                    </span>
                </div>
            @elseif (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'both')
                <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-bottom: 10px;">
                    <span>
                        @lang('shop::app.emails.orders.shipping-handling-excl-tax')
                    </span>

                    <span style="text-align: right; font-weight: 600;">
                        {{ core()->formatPrice($invoice->shipping_amount, $invoice->order_currency_code) }}
                    </span>
                </div>

                <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-bottom: 10px;">
                    <span>
                        @lang('shop::app.emails.orders.shipping-handling-incl-tax')
                    </span>

                    <span style="text-align: right; font-weight: 600;">
                        {{ core()->formatPrice($invoice->shipping_amount_incl_tax, $invoice->order_currency_code) }}
                    </span>
                </div>
            @else
                <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-bottom: 10px;">
                    <span>
                        @lang('shop::app.emails.orders.shipping-handling')
                    </span>

                    <span style="text-align: right; font-weight: 600;">
                        {{ core()->formatPrice($invoice->shipping_amount, $invoice->order_currency_code) }}
                    </span>
                </div>
            @endif
        @endif

        <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-bottom: 10px;">
            <span>
                @lang('shop::app.emails.orders.tax')
            </span>

            <span style="text-align: right; font-weight: 600;">
                {{ core()->formatPrice($invoice->tax_amount, $invoice->order_currency_code) }}
            </span>
        </div>

        @if ($invoice->discount_amount > 0)
            <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-bottom: 10px;">
                <span>
                    @lang('shop::app.emails.orders.discount')
                </span>

                <span style="text-align: right; font-weight: 600;">
                    {{ core()->formatPrice($invoice->discount_amount, $invoice->order_currency_code) }}
                </span>
            </div>
        @endif

        <div style="display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); font-weight: bold; margin-top: 20px; background-color: #eee1d2; padding: 15px; border-radius: 8px; font-size: 18px; color: #5B3722;">
            <span>
                @lang('shop::app.emails.orders.grand-total')
            </span>

            <span style="text-align: right;">
                {{ core()->formatPrice($invoice->grand_total, $invoice->order_currency_code) }}
            </span>
        </div>
    </div>

    <!-- Footer -->
    <div style="background-color: #eee1d2; border-radius: 8px; padding: 20px; text-align: center; color: #734A2E; margin-top: 30px;">
        <p style="margin: 0;">Gracias por tu compra. ¡Esperamos verte pronto!</p>
    </div>
@endcomponent