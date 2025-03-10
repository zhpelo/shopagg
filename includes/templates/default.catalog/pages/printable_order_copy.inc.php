<style>
    .logotype {
        max-width: 250px;
        max-height: 70px;
    }

    h1 {
        margin: 0;
        border: none;
    }

    .addresses .row {
        margin-bottom: 8mm;
    }

    .addresses .billing-address {
        margin-top: -4mm;
    }

    .rounded-rectangle {
        border: 1px solid #000;
        border-radius: 4mm;
        padding: 4mm;
        margin-inline-start: -15px;
    }

    .billing-address .value {
        margin: 0 !important;
    }

    .items tr th:last-child,
    .order-total tr td:last-child {
        width: 30mm;
    }

    .page .label {
        font-weight: bold;
        margin-bottom: 3pt;
    }

    .page .value {
        margin-bottom: 3mm;
    }

    .page .footer .row {
        margin-bottom: 0;
    }
</style>

<section class="page" data-size="<?php echo $paper_size; ?>" dir="<?php echo $text_direction; ?>">
    <header class="header">
        <div class="row">
            <div class="col-xs-6">
                <img class="logotype" src="<?php echo document::link('images/shopagg-logo.png'); ?>" alt="<?php echo settings::get('store_name'); ?>">
            </div>

            <div class="col-xs-6 text-end">
                <h1><?php echo language::translate('title_order', 'Order'); ?></h1>
                <div><?php echo language::translate('title_order', 'Order'); ?> #<?php echo $order['id']; ?></div>
                <div><?php echo !empty($order['date_created']) ? date(language::$selected['raw_date'], strtotime($order['date_created'])) : date(language::$selected['raw_date']); ?></div>
            </div>
        </div>
    </header>

    <main class="content">
        <div class="addresses">
            <div class="row">
                <div class="col-xs-3 shipping-address">
                    <div class="label"><?php echo language::translate('title_shipping_address', 'Shipping Address'); ?></div>
                    <div class="value"><?php echo nl2br(functions::escape_html(reference::country($order['customer']['shipping_address']['country_code'])->format_address($order['customer']['shipping_address'])), false); ?></div>
                </div>

                <div class="col-xs-3">
                    <div class="label"><?php echo language::translate('title_shipping_weight', 'Shipping Weight'); ?></div>
                    <div class="value"><?php echo !empty($order['weight_total']) ? weight::format($order['weight_total'], $order['weight_class'])  : '-'; ?></div>
                </div>

                <div class="col-xs-6 billing-address">
                    <div class="rounded-rectangle">
                        <div class="label"><?php echo language::translate('title_billing_address', 'Billing Address'); ?></div>
                        <div class="value"><?php echo nl2br(functions::escape_html(reference::country($order['customer']['country_code'])->format_address($order['customer'])), false); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 4mm;">

            <div class="col-xs-3">
                <div class="label"><?php echo language::translate('title_shipping_option', 'Shipping Option'); ?></div>
                <div class="value"><?php echo !empty($order['shipping_option']['name']) ? $order['shipping_option']['name'] : '-'; ?></div>

                <div class="label"><?php echo language::translate('title_shipping_tracking_id', 'Shipping Tracking ID'); ?></div>
                <div class="value"><?php echo !empty($order['shipping_tracking_id']) ? $order['shipping_tracking_id'] : '-'; ?></div>
            </div>

            <div class="col-xs-3">
                <div class="label"><?php echo language::translate('title_payment_option', 'Payment Option'); ?></div>
                <div class="value"><?php echo !empty($order['payment_option']['name']) ? $order['payment_option']['name'] : '-'; ?></div>

                <div class="label"><?php echo language::translate('title_transaction_number', 'Transaction Number'); ?></div>
                <div class="value"><?php echo !empty($order['payment_transaction_id']) ? $order['payment_transaction_id'] : '-'; ?></div>
            </div>

            <div class="col-xs-6">
                <div class="label"><?php echo language::translate('title_email', 'Email Address'); ?></div>
                <div class="value"><?php echo $order['customer']['email']; ?></div>

                <div class="row" style="margin-bottom: 0;">
                    <div class="col-md-6">
                        <div class="label"><?php echo language::translate('title_phone_number', 'Phone Number'); ?></div>
                        <div class="value"><?php echo $order['customer']['phone']; ?></div>
                    </div>

                    <div class="col-md-6">
                        <div class="label"><?php echo language::translate('title_tax_id', 'Tax ID'); ?></div>
                        <div class="value"><?php echo !empty($order['customer']['tax_id']) ? functions::escape_html($order['customer']['tax_id']) : '-'; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <table class="items table table-striped data-table">
            <thead>
                <tr>
                    <th><?php echo language::translate('title_sku', 'SKU'); ?></th>
                    <th class="main"><?php echo language::translate('title_item', 'Item'); ?></th>
                    <th><?php echo language::translate('title_qty', 'Qty'); ?></th>
                    <th class="text-end"><?php echo language::translate('title_unit_price', 'Unit Price'); ?></th>
                    <?php if ($order['tax_total']) { ?>
                        <th class="text-end"><?php echo language::translate('title_tax', 'Tax'); ?> </th>
                    <?php } ?>
                    <th class="text-end"><?php echo language::translate('title_sum', 'Sum'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($order['items'] as $item) { ?>
                    <tr>
                        <td><?php echo $item['sku']; ?></td>
                        <td style="white-space: normal;"><?php echo $item['name']; ?>
                            <?php
                            if (!empty($item['options'])) {
                                foreach ($item['options'] as $key => $value) {
                                    if (is_array($value)) {
                                        echo '<br>- ' . $key . ': ';
                                        $use_comma = false;
                                        foreach ($value as $v) {
                                            if ($use_comma) echo ', ';
                                            echo $v;
                                            $use_comma = true;
                                        }
                                    } else {
                                        echo '<br>- ' . $key . ': ' . $value;
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td><?php echo ($item['quantity'] > 1) ? '<strong>' . (float)$item['quantity'] . '</strong>' : (float)$item['quantity']; ?></td>
                        <td class="text-end"><?php echo currency::format(($order['display_prices_including_tax'] ? $item['price'] + $item['tax'] : $item['price']), false, $order['currency_code'], $order['currency_value']); ?></td>
                        <?php if ($order['tax_total']) { ?>
                            <td class="text-end"><?php echo currency::format($item['tax'], false, $order['currency_code'], $order['currency_value']); ?> (<?php echo ($item['price'] != 0 && $item['tax'] != 0) ? round($item['tax'] / $item['price'] * 100) : '0'; ?> %)</td>
                        <?php } ?>
                        <td class="text-end"><?php echo currency::format($item['quantity'] * ($order['display_prices_including_tax'] ? $item['price'] + $item['tax'] : $item['price']), false, $order['currency_code'], $order['currency_value']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <table class="order-total table data-table">
            <tbody>
                <?php foreach ($order['order_total'] as $ot_row) { ?>
                    <tr>
                        <td class="text-end"><?php echo $ot_row['title']; ?>:</td>
                        <td class="text-end"><?php echo currency::format($order['display_prices_including_tax'] ? $ot_row['value'] + $ot_row['tax'] : $ot_row['value'], false, $order['currency_code'], $order['currency_value']); ?></td>
                    </tr>
                <?php } ?>

                <?php if ((float)$order['tax_total'] != 0) { ?>
                    <tr>
                        <td class="text-end"><?php echo !empty($order['display_prices_including_tax']) ? language::translate('title_including_tax', 'Including Tax') : language::translate('title_excluding_tax', 'Excluding Tax'); ?>:</td>
                        <td class="text-end"><?php echo currency::format($order['tax_total'], false, $order['currency_code'], $order['currency_value']); ?></td>
                    </tr>
                <?php } ?>

                <tr>
                    <td class="text-end"><strong><?php echo language::translate('title_grand_total', 'Grand Total'); ?>:</strong></td>
                    <td class="text-end"><strong><?php echo currency::format_html($order['payment_due'], false, $order['currency_code'], $order['currency_value']); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </main>

    <?php if (count($order['items']) <= 10) { ?>
        <footer class="footer">

            <hr>

            <div class="row">
                <div class="col-xs-3">
                    <div class="label"><?php echo language::translate('title_address', 'Address'); ?></div>
                    <div class="value"><?php echo nl2br(settings::get('store_postal_address'), false); ?></div>
                </div>

                <div class="col-xs-3">
                    <?php if (settings::get('store_phone')) { ?>
                        <div class="label"><?php echo language::translate('title_phone', 'Phone'); ?></div>
                        <div class="value"><?php echo settings::get('store_phone'); ?></div>
                    <?php } ?>

                    <?php if (settings::get('store_tax_id')) { ?>
                        <div class="label"><?php echo language::translate('title_vat_registration_id', 'VAT Registration ID'); ?></div>
                        <div class="value"><?php echo settings::get('store_tax_id'); ?></div>
                    <?php } ?>
                </div>

                <div class="col-xs-3">
                    <div class="label"><?php echo language::translate('title_email', 'Email'); ?></div>
                    <div class="value"><?php echo settings::get('store_email'); ?></div>

                    <div class="label"><?php echo language::translate('title_website', 'Website'); ?></div>
                    <div class="value"><?php echo document::ilink(''); ?></div>
                </div>

                <div class="col-xs-3">
                </div>
            </div>

        </footer>
    <?php } ?>
</section>

<div id="actions">
    <ul class="list-unstyled">
        <li>
            <button name="print" class="btn btn-default btn-lg">
                <?php echo functions::draw_fonticon('fa-print'); ?> <?php echo language::translate('title_print', 'Print'); ?>
            </button>
        </li>
    </ul>
</div>

<script>
    document.title = "<?php echo functions::escape_js(language::translate('title_order', 'Order')); ?> #<?php echo $order['id']; ?>";

    $('#actions button[name="print"]').click(function() {
        window.print();
    });
</script>