<?php

#[AllowDynamicProperties]
class ot_shipping_fee
{
    public $id = __CLASS__;
    public $name = 'Shipping Fee';
    public $description = '';
    public $author = 'SHOPAGG Dev Team';
    public $version = '1.0';
    public $website = 'https://shopagg.org';
    public $priority = 0;

    public function __construct()
    {
        $this->name = language::translate(__CLASS__ . ':title', 'Shipping Fee');
    }

    public function process($order)
    {

        if (empty($this->settings['status'])) return;

        if (empty($order->data['shipping_option']['cost']) || (float)$order->data['shipping_option']['cost'] == 0) return;

        $output = [];

        $output[] = [
            'title' => $order->data['shipping_option']['title'] . ' (' . $order->data['shipping_option']['name'] . ')',
            'value' => $order->data['shipping_option']['cost'],
            'tax' => tax::get_tax($order->data['shipping_option']['cost'], $order->data['shipping_option']['tax_class_id'], $order->data['customer']),
            'calculate' => true,
        ];

        if (!empty($this->settings['free_shipping_table'])) {

            // Calculate cart total
            $subtotal = 0;
            foreach ($order->data['items'] as $item) {
                $subtotal += $item['quantity'] * $item['price'];
            }

            // Check for free shipping
            $free_shipping = $this->_get_free_shipping($subtotal, $order->data['customer']['shipping_address']);

            if ($free_shipping) {
                $output[] = [
                    'title' => language::translate('title_free_shipping', 'Free Shipping'),
                    'value' => -$order->data['shipping_option']['cost'],
                    'tax' => -tax::get_tax($order->data['shipping_option']['cost'], $order->data['shipping_option']['tax_class_id'], $order->data['customer']),
                    'tax_class_id' => $order->data['shipping_option']['tax_class_id'],
                    'calculate' => true,
                ];
            }
        }

        return $output;
    }

    private function _get_free_shipping($subtotal, $address)
    {

        if (!$free_shipping_table = functions::csv_decode($this->settings['free_shipping_table'], ',')) return;

        foreach ($free_shipping_table as $row) {
            if (!empty($row['country_code']) && $row['country_code'] == $address['country_code']) {
                if (empty($row['zone_code']) || $row['zone_code'] == $address['zone_code']) {
                    return ($subtotal >= $row['min_subtotal']) ? true : false;
                }
            }
        }

        foreach ($free_shipping_table as $row) {
            if (!empty($row['country_code']) && $row['country_code'] == 'XX') {
                if ($subtotal >= $row['min_subtotal']) return true;
            }
        }
    }

    function settings()
    {
        return [
            [
                'key' => 'status',
                'default_value' => '1',
                'title' => language::translate(__CLASS__ . ':title_status', 'Status'),
                'description' => language::translate(__CLASS__ . ':description_status', 'Enables or disables the module.'),
                'function' => 'toggle("e/d")',
            ],
            [
                'key' => 'free_shipping_table',
                'default_value' => 'country_code,zone_code,min_subtotal',
                'title' => language::translate(__CLASS__ . ':title_free_shipping_table', 'Free Shipping Table'),
                'description' => language::translate(__CLASS__ . ':description_free_shipping_table', 'Free shipping table in standard CSV format with column headers.'),
                'function' => 'csv()',
            ],
            [
                'key' => 'priority',
                'default_value' => '20',
                'title' => language::translate(__CLASS__ . ':title_priority', 'Priority'),
                'description' => language::translate(__CLASS__ . ':description_priority', 'Process this module by the given priority value.'),
                'function' => 'number()',
            ],
        ];
    }

    public function install() {}

    public function uninstall() {}
}
