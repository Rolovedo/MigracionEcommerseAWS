@component('shop::emails.layout')
    <div style="margin-bottom: 34px; background-color: #f8f4ec; padding: 25px; border-radius: 8px;">
        <span style="font-size: 24px; font-weight: 600; color: #8B5E3C;">
            @lang('shop::app.emails.orders.shipped.title')
        </span> <br>

        <p style="font-size: 16px; color: #5B3722; line-height: 24px; margin-top: 15px;">
            @lang('shop::app.emails.dear', ['customer_name' => $shipment->order->customer_full_name]),👋
        </p>

        <p style="font-size: 16px; color: #5B3722; line-height: 24px;">
            @lang('shop::app.emails.orders.shipped.greeting', [
                'invoice_id' => $shipment->increment_id,
                'order_id'   => '<a href="' . route('shop.customers.account.orders.view', $shipment->order_id) . '" style="color: #B8825B; font-weight: 600; text-decoration: underline;">#' . $shipment->order->increment_id . '</a>',
                'created_at' => core()->formatDate($shipment->order->created_at, 'Y-m-d H:i:s')
            ])
        </p>
    </div>

    <div style="font-size: 22px; font-weight: 600; color: #8B5E3C; margin-bottom: 15px; border-bottom: 2px solid #eee1d2; padding-bottom: 10px;">
        @lang('shop::app.emails.orders.shipped.summary')
    </div>

    <div style="display: flex; flex-direction: row; margin-top: 20px; justify-content: space-between; margin-bottom: 40px;">
        @if ($shipment->order->shipping_address)
            <div style="line-height: 25px; background-color: #F4E8E0; padding: 20px; border-radius: 8px; width: 48%;">
                <div style="font-size: 18px; font-weight: 600; color: #734A2E; margin-bottom: 12px;">
                    @lang('shop::app.emails.orders.shipping-address')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #5B3722; margin-bottom: 30px;">
                    {{ $shipment->order->shipping_address->company_name ?? '' }}<br/>

                    {{ $shipment->order->shipping_address->name }}<br/>

                    {{ $shipment->order->shipping_address->address }}<br/>

                    {{ $shipment->order->shipping_address->postcode . " " . $shipment->order->shipping_address->city }}<br/>

                    {{ $shipment->order->shipping_address->state }}<br/>

                    <div style="margin: 10px 0; border-top: 1px solid #D9B89E;"></div>

                    @lang('shop::app.emails.orders.contact') : <span style="font-weight: 500;">{{ $shipment->order->billing_address->phone }}</span>
                </div>

                <div style="font-size: 18px; font-weight: 600; color: #734A2E; margin-bottom: 12px;">
                    @lang('shop::app.emails.orders.shipping')
                </div>

                <div style="font-size: 16px; font-weight: 500; color: #8B5E3C; margin-bottom: 10px;">
                    {{ $shipment->order->shipping_title }}
                </div>


                <div style="font-size: 16px; color: #5B3722;">
                    <div style="margin-top: 8px;">
                        <span style="font-weight: 500;">
                            @lang('shop::app.emails.orders.carrier') :
                        </span>

                        {{ $shipment->carrier_title }}
                    </div>

                    <div style="margin-top: 8px; background-color: #eee1d2; padding: 8px; border-radius: 4px; display: inline-block;">
                        <span style="font-weight: 500;">
                            @lang('shop::app.emails.orders.tracking-number', ['tracking_number' =>  $shipment->track_number])
                        </span>
                    </div>
                </div>

                @php $additionalDetails = \Webkul\Payment\Payment::getAdditionalDetails($shipment->order->payment->method); @endphp

                @if (! empty($additionalDetails))
                    <div style="font-size: 16px; color: #5B3722; margin-top: 15px;">
                        <div>
                            <span style="font-weight: 500;">{{ $additionalDetails->title }} : </span>
                        </div>

                        <div style="margin-top: 5px;">
                            <span>{{ $additionalDetails->value }} </span>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @if ($shipment->order->billing_address)
            <div style="line-height: 25px; background-color: #F4E8E0; padding: 20px; border-radius: 8px; width: 48%;">
                <div style="font-size: 18px; font-weight: 600; color: #734A2E; margin-bottom: 12px;">
                    @lang('shop::app.emails.orders.billing-address')
                </div>

                <div style="font-size: 16px; font-weight: 400; color: #5B3722; margin-bottom: 30px;">
                    {{ $shipment->order->billing_address->company_name ?? '' }}<br/>

                    {{ $shipment->order->billing_address->name }}<br/>

                    {{ $shipment->order->billing_address->address }}<br/>

                    {{ $shipment->order->billing_address->postcode . " " . $shipment->order->billing_address->city }}<br/>

                    {{ $shipment->order->billing_address->state }}<br/>

                    <div style="margin: 10px 0; border-top: 1px solid #D9B89E;"></div>

                    @lang('shop::app.emails.orders.contact') : <span style="font-weight: 500;">{{ $shipment->order->billing_address->phone }}</span>
                </div>

                <div style="font-size: 18px; font-weight: 600; color: #734A2E; margin-bottom: 12px;">
                    @lang('shop::app.emails.orders.payment')
                </div>

                <div style="font-size: 16px; font-weight: 500; color: #8B5E3C; padding: 8px; background-color: #eee1d2; border-radius: 4px; display: inline-block;">
                    {{ core()->getConfigData('sales.payment_methods.' . $shipment->order->payment->method . '.title') }}
                </div>
            </div>
        @endif
    </div>

    <div style="padding-bottom: 40px; border-bottom: 2px solid #eee1d2;">
        <table style="overflow-x: auto; border-collapse: collapse; border-spacing: 0; width: 100%; border-radius: 8px; overflow: hidden;">
            <thead>
                <tr style="background-color: #8B5E3C; color: #F4E8E0;">
                    @foreach (['sku', 'name', 'price', 'qty'] as $item)
                        <th style="text-align: left; padding: 15px;">
                            @lang('shop::app.emails.orders.' . $item)
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody style="font-size: 16px; font-weight: 400; color: #5B3722;">
                @foreach ($shipment->items as $item)
                    <tr style="vertical-align: text-top; background-color: {{ $loop->even ? '#f8f4ec' : '#fff' }};">
                        <td style="text-align: left; padding: 15px; border-bottom: 1px solid #eee1d2;">
                            <span style="font-family: monospace; background-color: #eee1d2; padding: 3px 6px; border-radius: 3px;">{{ $item->sku }}</span>
                        </td>

                        <td style="text-align: left; padding: 15px; border-bottom: 1px solid #eee1d2;">
                            <strong style="color: #734A2E;">{{ $item->name }}</strong>

                            @if (isset($item->additional['attributes']))
                                <div style="margin-top: 8px; font-size: 14px;">
                                    @foreach ($item->additional['attributes'] as $attribute)
                                        <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                                    @endforeach
                                </div>
                            @endif
                        </td>

                        <td style="display: flex; flex-direction: column; text-align: left; padding: 15px; border-bottom: 1px solid #eee1d2;">
                            @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                <span style="color: #8B5E3C; font-weight: 600;">{{ core()->formatPrice($item->price_incl_tax, $shipment->order->order_currency_code) }}</span>
                            @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                <span style="color: #8B5E3C; font-weight: 600;">{{ core()->formatPrice($item->price_incl_tax, $shipment->order->order_currency_code) }}</span>

                                <span style="font-size: 12px; white-space: nowrap; margin-top: 5px;">
                                    @lang('shop::app.emails.orders.excl-tax')

                                    <span style="font-weight: 600;">
                                        {{ core()->formatPrice($item->price, $shipment->order->order_currency_code) }}
                                    </span>
                                </span>
                            @else
                                <span style="color: #8B5E3C; font-weight: 600;">{{ core()->formatPrice($item->price, $shipment->order->order_currency_code) }}</span>
                            @endif
                        </td>

                        <td style="text-align: left; padding: 15px; border-bottom: 1px solid #eee1d2;">
                            <span style="background-color: #eee1d2; padding: 5px 10px; border-radius: 12px; font-weight: 500;">{{ $item->qty }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 30px; text-align: center; background-color: #f8f4ec; padding: 20px; border-radius: 8px;">
        <p style="font-size: 16px; color: #8B5E3C; margin-bottom: 0;">
            ¡Gracias por su compra!
        </p>
    </div>
@endcomponent