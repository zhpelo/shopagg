<main id="content" class="fourteen-forty">
    {snippet:notices}

    <div class="row">
        <div class="col-md-6">
            <section id="box-order-success" class="card" data-id="<?php echo $order['id']; ?>" data-payment-due="<?php echo currency::format_raw($order['payment_due'], $order['currency_code']); ?>" data-total-tax="<?php echo currency::format_raw($order['tax_total'], $order['currency_code']); ?>" data-currency-code="<?php echo $order['currency_code']; ?>" data-transaction-id="<?php echo $order['payment_transaction_id']; ?>">

                <div class="card-header">
                    <h1 class="card-title"><?php echo strtr(language::translate('title_order_completed', 'Your order #%order_id was completed successfully!'), ['%order_id' => $order['id']]); ?></h1>
                </div>

                <div class="card-body">
                    <p><?php echo language::translate('description_order_completed', 'Thank you for your purchase. An order confirmation email has been sent. We will process your order shortly.'); ?></p>

                    <ul class="items list-unstyled">
                        <?php foreach ($order['items'] as $item) { ?>
                            <li class="item" data-id="<?php echo $item['product_id']; ?>" data-sku="<?php echo $item['sku']; ?>" data-name="<?php echo functions::escape_html($item['name']); ?>" data-price="<?php echo currency::format_raw($item['price'], $order['currency_code'], $order['currency_value']); ?>" data-quantity="<?php echo (float)$item['quantity']; ?>">
                                <?php echo (float)$item['quantity']; ?> x <?php echo $item['name']; ?>
                            </li>
                        <?php } ?>
                    </ul>

                    <p><strong><?php echo language::translate('title_order_total', 'Order Total'); ?></strong>: <?php echo currency::format($order['payment_due'], false, $order['currency_code'], $order['currency_value']); ?></p>

                    <p><a class="btn btn-default" href="<?php echo functions::escape_html($printable_link); ?>" target="_blank"><?php echo language::translate('description_click_printable_copy', 'Click here for a printable copy'); ?></a></p>

                </div>
            </section>
        </div>

        <div class="col-md-6">
            <?php if ($payment_receipt) echo $payment_receipt; ?>

            <?php if ($order_success_modules_output) echo $order_success_modules_output; ?>
        </div>
    </div>
</main>