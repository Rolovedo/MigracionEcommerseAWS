<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>
    <head>
        <!-- meta tags -->
        <meta
            http-equiv="Cache-control"
            content="no-cache"
        >

        <meta
            http-equiv="Content-Type"
            content="text/html; charset=utf-8"
        />

        @php
            $fontPath = [];

            // Get the default locale code.
            $getLocale = app()->getLocale();

            // Get the current currency code.
            $currencyCode = core()->getBaseCurrencyCode();

            if ($getLocale == 'en' && $currencyCode == 'INR') {
                $fontFamily = [
                    'regular' => 'DejaVu Sans',
                    'bold'    => 'DejaVu Sans',
                ];
            }  else {
                $fontFamily = [
                    'regular' => 'Arial, sans-serif',
                    'bold'    => 'Arial, sans-serif',
                ];
            }


            if (in_array($getLocale, ['ar', 'he', 'fa', 'tr', 'ru', 'uk'])) {
                $fontFamily = [
                    'regular' => 'DejaVu Sans',
                    'bold'    => 'DejaVu Sans',
                ];
            } elseif ($getLocale == 'zh_CN') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansSC-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansSC-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans SC',
                    'bold'    => 'Noto Sans SC Bold',
                ];
            } elseif ($getLocale == 'ja') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansJP-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansJP-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans JP',
                    'bold'    => 'Noto Sans JP Bold',
                ];
            } elseif ($getLocale == 'hi_IN') {
                $fontPath = [
                    'regular' => asset('fonts/Hind-Regular.ttf'),
                    'bold'    => asset('fonts/Hind-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Hind',
                    'bold'    => 'Hind Bold',
                ];
            } elseif ($getLocale == 'bn') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansBengali-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansBengali-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans Bengali',
                    'bold'    => 'Noto Sans Bengali Bold',
                ];
            } elseif ($getLocale == 'sin') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansSinhala-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansSinhala-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans Sinhala',
                    'bold'    => 'Noto Sans Sinhala Bold',
                ];
            }
        @endphp

        <!-- lang supports inclusion -->
        <style type="text/css">
            @if (! empty($fontPath['regular']))
                @font-face {
                    src: url({{ $fontPath['regular'] }}) format('truetype');
                    font-family: {{ $fontFamily['regular'] }};
                }
            @endif

            @if (! empty($fontPath['bold']))
                @font-face {
                    src: url({{ $fontPath['bold'] }}) format('truetype');
                    font-family: {{ $fontFamily['bold'] }};
                    font-style: bold;
                }
            @endif

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: {{ $fontFamily['regular'] }};
            }

            body {
                font-size: 10px;
                color: #091341;
                font-family: "{{ $fontFamily['regular'] }}";
            }

            b, th {
                font-family: "{{ $fontFamily['bold'] }}";
            }

            .page-content {
                padding: 12px;
            }

            .page-header {
                border-bottom: 1px solid #E9EFFC;
                text-align: center;
                font-size: 24px;
                text-transform: uppercase;
                color: #000DBB;
                padding: 24px 0;
                margin: 0;
            }

            .logo-container {
                position: absolute;
                top: 20px;
                left: 20px;
            }

            .logo-container.rtl {
                left: auto;
                right: 20px;
            }

            .logo-container img {
                max-width: 100%;
                height: auto;
            }

            .page-header b {
                display: inline-block;
                vertical-align: middle;
            }

            .small-text {
                font-size: 7px;
            }

            table {
                width: 100%;
                border-spacing: 1px 0;
                border-collapse: separate;
                margin-bottom: 16px;
            }

            table thead th {
                background-color: #E9EFFC;
                color: #000DBB;
                padding: 6px 18px;
                text-align: left;
            }

            table.rtl thead tr th {
                text-align: right;
            }

            table tbody td {
                padding: 9px 18px;
                border-bottom: 1px solid #E9EFFC;
                text-align: left;
                vertical-align: top;
            }

            table.rtl tbody tr td {
                text-align: right;
            }

            .summary {
                width: 100%;
                display: inline-block;
            }

            .summary table {
                float: right;
                width: 250px;
                padding-top: 5px;
                padding-bottom: 5px;
                background-color: #E9EFFC;
                white-space: nowrap;
            }

            .summary table.rtl {
                width: 280px;
            }

            .summary table.rtl {
                margin-right: 480px;
            }

            .summary table td {
                padding: 5px 10px;
            }

            .summary table td:nth-child(2) {
                text-align: center;
            }

            .summary table td:nth-child(3) {
                text-align: right;
            }
        </style>
    </head>

    <body dir="{{ core()->getCurrentLocale()->direction }}">
        <div class="logo-container {{ core()->getCurrentLocale()->direction }}">
            @if (core()->getConfigData('sales.invoice_settings.pdf_print_outs.logo'))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(Storage::url(core()->getConfigData('sales.invoice_settings.pdf_print_outs.logo')))) }}"/>
            @else
                <img src="data:image/png;base64,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"/>
            @endif
        </div>

        <div class="page">
            <!-- Header -->
            <div class="page-header">
                <b>@lang('admin::app.sales.invoices.invoice-pdf.invoice')</b>
            </div>

            <div class="page-content">
                <!-- Invoice Information -->
                <table class="{{ core()->getCurrentLocale()->direction }}">
                    <tbody>
                        <tr>
                            @if (core()->getConfigData('sales.invoice_settings.pdf_print_outs.invoice_id'))
                                <td style="width: 50%; padding: 2px 18px;border:none;">
                                    <b>
                                        @lang('admin::app.sales.invoices.invoice-pdf.invoice-id'):
                                    </b>

                                    <span>
                                        #{{ $invoice->increment_id ?? $invoice->id }}
                                    </span>
                                </td>
                            @endif

                            @if (core()->getConfigData('sales.invoice_settings.pdf_print_outs.order_id'))
                                <td style="width: 50%; padding: 2px 18px;border:none;">
                                    <b>
                                        @lang('admin::app.sales.invoices.invoice-pdf.order-id'):
                                    </b>

                                    <span>
                                        #{{ $invoice->order->increment_id }}
                                    </span>
                                </td>
                            @endif
                        </tr>

                        <tr>
                            <td style="width: 50%; padding: 2px 18px;border:none;">
                                <b>
                                    @lang('admin::app.sales.invoices.invoice-pdf.date'):
                                </b>

                                <span>
                                    {{ core()->formatDate($invoice->created_at, 'd-m-Y') }}
                                </span>
                            </td>

                            <td style="width: 50%; padding: 2px 18px;border:none;">
                                <b>
                                    @lang('admin::app.sales.invoices.invoice-pdf.order-date'):
                                </b>

                                <span>
                                    {{ core()->formatDate($invoice->order->created_at, 'd-m-Y') }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Invoice Information -->
                <table class="{{ core()->getCurrentLocale()->direction }}">
                    <tbody>
                        <tr>
                            @if (! empty(core()->getConfigData('sales.shipping.origin.country')))
                                <td style="width: 50%; padding: 2px 18px;border:none;">
                                    <b style="display: inline-block; margin-bottom: 4px;">
                                        {{ core()->getConfigData('sales.shipping.origin.store_name') }}
                                    </b>

                                    <div>
                                        <div>{{ core()->getConfigData('sales.shipping.origin.address') }}</div>

                                        <div>{{ core()->getConfigData('sales.shipping.origin.zipcode') . ' ' . core()->getConfigData('sales.shipping.origin.city') }}</div>

                                        <div>{{ core()->getConfigData('sales.shipping.origin.state') . ', ' . core()->getConfigData('sales.shipping.origin.country') }}</div>
                                    </div>
                                </td>
                            @endif

                            <td style="width: 50%; padding: 2px 18px;border:none;">
                                @if ($invoice->hasPaymentTerm())
                                    <div style="margin-bottom: 12px">
                                        <b style="display: inline-block; margin-bottom: 4px;">
                                            @lang('admin::app.sales.invoices.invoice-pdf.payment-terms'):
                                        </b>

                                        <span>
                                            {{ $invoice->getFormattedPaymentTerm() }}
                                        </span>
                                    </div>
                                @endif

                                @if (core()->getConfigData('sales.shipping.origin.bank_details'))
                                    <div>
                                        <b style="display: inline-block; margin-bottom: 4px;">
                                            @lang('admin::app.sales.invoices.invoice-pdf.bank-details'):
                                        </b>

                                        <div>
                                            {!! nl2br(core()->getConfigData('sales.shipping.origin.bank_details')) !!}
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Billing & Shipping Address -->
                <table class="{{ core()->getCurrentLocale()->direction }}">
                    <thead>
                        <tr>
                            @if ($invoice->order->billing_address)
                                <th style="width: 50%;">
                                    <b>
                                        @lang('admin::app.sales.invoices.invoice-pdf.bill-to')
                                    </b>
                                </th>
                            @endif

                            @if ($invoice->order->shipping_address)
                                <th style="width: 50%">
                                    <b>
                                        @lang('admin::app.sales.invoices.invoice-pdf.ship-to')
                                    </b>
                                </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            @if ($invoice->order->billing_address)
                                <td style="width: 50%">
                                    <div>{{ $invoice->order->billing_address->company_name ?? '' }}<div>

                                    <div>{{ $invoice->order->billing_address->name }}</div>

                                    <div>{{ $invoice->order->billing_address->address }}</div>

                                    <div>{{ $invoice->order->billing_address->postcode . ' ' . $invoice->order->billing_address->city }}</div>

                                    <div>{{ $invoice->order->billing_address->state . ', ' . core()->country_name($invoice->order->billing_address->country) }}</div>

                                    <div>@lang('admin::app.sales.invoices.invoice-pdf.contact'): {{ $invoice->order->billing_address->phone }}</div>
                                </td>
                            @endif

                            @if ($invoice->order->shipping_address)
                                <td style="width: 50%">
                                    <div>{{ $invoice->order->shipping_address->company_name ?? '' }}<div>

                                    <div>{{ $invoice->order->shipping_address->name }}</div>

                                    <div>{{ $invoice->order->shipping_address->address }}</div>

                                    <div>{{ $invoice->order->shipping_address->postcode . ' ' . $invoice->order->shipping_address->city }}</div>

                                    <div>{{ $invoice->order->shipping_address->state . ', ' . core()->country_name($invoice->order->shipping_address->country) }}</div>

                                    <div>@lang('admin::app.sales.invoices.invoice-pdf.contact'): {{ $invoice->order->shipping_address->phone }}</div>
                                </td>
                            @endif
                        </tr>
                    </tbody>
                </table>

                <!-- Payment & Shipping Methods -->
                <table class="{{ core()->getCurrentLocale()->direction }}">
                    <thead>
                        <tr>
                            <th style="width: 50%">
                                <b>
                                    @lang('admin::app.sales.invoices.invoice-pdf.payment-method')
                                </b>
                            </th>

                            @if ($invoice->order->shipping_address)
                                <th style="width: 50%">
                                    <b>
                                        @lang('admin::app.sales.invoices.invoice-pdf.shipping-method')
                                    </b>
                                </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td style="width: 50%">
                                {{ core()->getConfigData('sales.payment_methods.' . $invoice->order->payment->method . '.title') }}

                                @php $additionalDetails = \Webkul\Payment\Payment::getAdditionalDetails($invoice->order->payment->method); @endphp

                                @if (! empty($additionalDetails))
                                    <div class="row small-text">
                                        <span>{{ $additionalDetails['title'] }}:</span>

                                        <span>{{ $additionalDetails['value'] }}</span>
                                    </div>
                                @endif
                            </td>

                            @if ($invoice->order->shipping_address)
                                <td style="width: 50%">
                                    {{ $invoice->order->shipping_title }}
                                </td>
                            @endif
                        </tr>
                    </tbody>
                </table>

                <!-- Items -->
                <div class="items">
                    <table class="{{ core()->getCurrentLocale()->direction }}">
                        <thead>
                            <tr>
                                <th>
                                    @lang('admin::app.sales.invoices.invoice-pdf.sku')
                                </th>

                                <th>
                                    @lang('admin::app.sales.invoices.invoice-pdf.product-name')
                                </th>

                                <th>
                                    @lang('admin::app.sales.invoices.invoice-pdf.price')
                                </th>

                                <th>
                                    @lang('admin::app.sales.invoices.invoice-pdf.qty')
                                </th>

                                <th>
                                    @lang('admin::app.sales.invoices.invoice-pdf.subtotal')
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($invoice->items as $item)
                                <tr>
                                    <td>
                                        {{ $item->getTypeInstance()->getOrderedItem($item)->sku }}
                                    </td>

                                    <td>
                                        {{ $item->name }}

                                        @if (isset($item->additional['attributes']))
                                            <div>
                                                @foreach ($item->additional['attributes'] as $attribute)
                                                    <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                            {!! core()->formatBasePrice($item->base_price_incl_tax, true) !!}
                                        @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                            {!! core()->formatBasePrice($item->base_price_incl_tax, true) !!}

                                            <div class="small-text">
                                                @lang('admin::app.sales.invoices.invoice-pdf.excl-tax')

                                                <span>
                                                    {{ core()->formatPrice($item->base_price) }}
                                                </span>
                                            </div>
                                        @else
                                            {!! core()->formatBasePrice($item->base_price, true) !!}
                                        @endif
                                    </td>

                                    <td>
                                        {{ $item->qty }}
                                    </td>

                                    <td>
                                        @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
                                            {!! core()->formatBasePrice($item->base_total_incl_tax, true) !!}
                                        @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
                                            {!! core()->formatBasePrice($item->base_total_incl_tax, true) !!}

                                            <div class="small-text">
                                                @lang('admin::app.sales.invoices.invoice-pdf.excl-tax')

                                                <span>
                                                    {{ core()->formatPrice($item->base_total) }}
                                                </span>
                                            </div>
                                        @else
                                            {!! core()->formatBasePrice($item->base_total, true) !!}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Summary Table -->
                <div class="summary">
                    <table class="{{ core()->getCurrentLocale()->direction }}">
                        <tbody>
                            @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.subtotal')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_sub_total_incl_tax, true) !!}</td>
                                </tr>
                            @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.subtotal-incl-tax')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_sub_total_incl_tax, true) !!}</td>
                                </tr>

                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.subtotal-excl-tax')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_sub_total, true) !!}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.subtotal')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_sub_total, true) !!}</td>
                                </tr>
                            @endif

                            @if (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'including_tax')
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.shipping-handling')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_shipping_amount_incl_tax, true) !!}</td>
                                </tr>
                            @elseif (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'both')
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.shipping-handling-incl-tax')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_shipping_amount_incl_tax, true) !!}</td>
                                </tr>

                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.shipping-handling-excl-tax')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_shipping_amount, true) !!}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.shipping-handling')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_shipping_amount, true) !!}</td>
                                </tr>
                            @endif

                            <tr>
                                <td>@lang('admin::app.sales.invoices.invoice-pdf.tax')</td>
                                <td>-</td>
                                <td>{!! core()->formatBasePrice($invoice->base_tax_amount, true) !!}</td>
                            </tr>

                            <tr>
                                <td>@lang('admin::app.sales.invoices.invoice-pdf.discount')</td>
                                <td>-</td>
                                <td>{!! core()->formatBasePrice($invoice->base_discount_amount, true) !!}</td>
                            </tr>

                            <tr>
                                <td style="border-top: 1px solid #FFFFFF;">
                                    <b>@lang('admin::app.sales.invoices.invoice-pdf.grand-total')</b>
                                </td>
                                <td style="border-top: 1px solid #FFFFFF;">-</td>
                                <td style="border-top: 1px solid #FFFFFF;">
                                    <b>{!! core()->formatBasePrice($invoice->base_grand_total, true) !!}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
