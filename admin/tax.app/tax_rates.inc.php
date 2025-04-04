<?php

if (empty($_GET['page']) || !is_numeric($_GET['page']) || $_GET['page'] < 1) {
    $_GET['page'] = 1;
}

document::$snippets['title'][] = language::translate('title_tax_rates', 'Tax Rates');

breadcrumbs::add(language::translate('title_tax_rates', 'Tax Rates'));

// Table Rows
$tax_rates = [];

$tax_rates_query = database::query(
    "select tr.*, gz.name as geo_zone, tc.name as tax_class from " . DB_TABLE_PREFIX . "tax_rates tr
    left join " . DB_TABLE_PREFIX . "geo_zones gz on (gz.id = tr.geo_zone_id)
    left join " . DB_TABLE_PREFIX . "tax_classes tc on (tc.id = tr.tax_class_id)
    order by tc.name, gz.name, tr.name;"
);

if ($_GET['page'] > 1) database::seek($tax_rates_query, settings::get('data_table_rows_per_page') * ($_GET['page'] - 1));

$page_items = 0;
while ($tax_rate = database::fetch($tax_rates_query)) {
    $tax_rates[] = $tax_rate;
    if (++$page_items == settings::get('data_table_rows_per_page')) break;
}

// Number of Rows
$num_rows = database::num_rows($tax_rates_query);

// Pagination
$num_pages = ceil($num_rows / settings::get('data_table_rows_per_page'));
?>
<div class="card card-app">
    <div class="card-header">
        <div class="card-title">
            <?php echo $app_icon; ?> <?php echo language::translate('title_tax_rates', 'Tax Rates'); ?>
        </div>
    </div>

    <div class="card-action">
        <ul class="list-inline">
            <li><?php echo functions::form_draw_link_button(document::link(WS_DIR_ADMIN, ['doc' => 'edit_tax_rate'], true), language::translate('title_create_new_tax_rate', 'Create New Tax Rate'), '', 'add'); ?></li>
        </ul>
    </div>

    <?php echo functions::form_draw_form_begin('tax_rates_form', 'post'); ?>

    <table class="table table-striped table-hover data-table">
        <thead>
            <tr>
                <th><?php echo functions::draw_fonticon('fa-check-square-o fa-fw', 'data-toggle="checkbox-toggle"'); ?></th>
                <th><?php echo language::translate('title_id', 'ID'); ?></th>
                <th><?php echo language::translate('title_tax_class', 'Tax Class'); ?></th>
                <th><?php echo language::translate('title_geo_zone', 'Geo Zone'); ?></th>
                <th><?php echo language::translate('title_name', 'Name'); ?></th>
                <th class="main"><?php echo language::translate('title_description', 'Description'); ?></th>
                <th><?php echo language::translate('title_rate', 'Rate'); ?></th>
                <th><?php echo language::translate('title_type', 'Type'); ?></th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($tax_rates as $tax_rate) { ?>
                <tr>
                    <td><?php echo functions::form_draw_checkbox('tax_rates[]', $tax_rate['id']); ?></td>
                    <td><?php echo $tax_rate['id']; ?></td>
                    <td><?php echo $tax_rate['tax_class']; ?></td>
                    <td><?php echo $tax_rate['geo_zone']; ?></td>
                    <td><a class="link" href="<?php echo document::href_link('', ['doc' => 'edit_tax_rate', 'tax_rate_id' => $tax_rate['id']], true); ?>"><?php echo $tax_rate['name']; ?></a></td>
                    <td><?php echo $tax_rate['description']; ?></td>
                    <td><?php echo language::number_format($tax_rate['rate'], 4); ?></td>
                    <td><?php echo $tax_rate['type']; ?></td>
                    <td><a class="btn btn-default btn-sm" href="<?php echo document::href_link('', ['doc' => 'edit_tax_rate', 'tax_rate_id' => $tax_rate['id']], true); ?>" title="<?php echo functions::escape_html(language::translate('title_edit', 'Edit')); ?>"><?php echo functions::draw_fonticon('fa-pencil'); ?></a></td>
                </tr>
            <?php } ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="9"><?php echo language::translate('title_tax_rates', 'Tax Rates'); ?>: <?php echo $num_rows; ?></td>
            </tr>
        </tfoot>
    </table>

    <?php echo functions::form_draw_form_end(); ?>

    <?php if ($num_pages > 1) { ?>
        <div class="card-footer">
            <?php echo functions::draw_pagination($num_pages); ?>
        </div>
    <?php } ?>
</div>