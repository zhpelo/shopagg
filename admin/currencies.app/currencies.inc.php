<?php

if (empty($_GET['page']) || !is_numeric($_GET['page']) || $_GET['page'] < 1) {
    $_GET['page'] = 1;
}

document::$snippets['title'][] = language::translate('title_currencies', 'Currencies');

breadcrumbs::add(language::translate('title_currencies', 'Currencies'));

if (isset($_POST['enable']) || isset($_POST['disable'])) {

    try {
        if (empty($_POST['currencies'])) throw new Exception(language::translate('error_must_select_currencies', 'You must select currencies'));

        foreach ($_POST['currencies'] as $currency_id) {
            $currency = new ent_currency($currency_id);
            $currency->data['status'] = !empty($_POST['enable']) ? 1 : 0;
            $currency->save();
        }

        notices::add('success', language::translate('success_changes_saved', 'Changes saved'));
        header('Location: ' . document::link());
        exit;
    } catch (Exception $e) {
        notices::add('errors', $e->getMessage());
    }
}

// Table Rows
$currencies = [];

$currencies_query = database::query(
    "select * from " . DB_TABLE_PREFIX . "currencies
    order by field(status, 1, -1, 0), priority, name;"
);

while ($currency = database::fetch($currencies_query)) {
    switch ($currency['status']) {
        case '1':
            $currency['status_color'] = '#88cc44';
            break;
        case '-1':
            $currency['status_color'] = '#ded90f';
            break;
        case '0':
            $currency['status_color'] = '#ff6644';
            break;
    }
    $currencies[] = $currency;
}

// Number of Rows
$num_rows = database::num_rows($currencies_query);

// Pagination
$num_pages = ceil($num_rows / settings::get('data_table_rows_per_page'));
?>
<div class="card card-app">
    <div class="card-header">
        <div class="card-title">
            <?php echo $app_icon; ?> <?php echo language::translate('title_currencies', 'Currencies'); ?>
        </div>
    </div>

    <div class="card-action">
        <ul class="list-inline">
            <li><?php echo functions::form_draw_link_button(document::link(WS_DIR_ADMIN, ['doc' => 'edit_currency'], true), language::translate('title_create_new_currency', 'Create New Currency'), '', 'add'); ?></li>
        </ul>
    </div>

    <?php echo functions::form_draw_form_begin('currencies_form', 'post'); ?>

    <table class="table table-striped table-hover data-table">
        <thead>
            <tr>
                <th><?php echo functions::draw_fonticon('fa-check-square-o fa-fw', 'data-toggle="checkbox-toggle"'); ?></th>
                <th></th>
                <th><?php echo language::translate('title_id', 'ID'); ?></th>
                <th><?php echo language::translate('title_code', 'Code'); ?></th>
                <th class="main"><?php echo language::translate('title_name', 'Name'); ?></th>
                <th><?php echo language::translate('title_value', 'Value'); ?></th>
                <th><?php echo language::translate('title_decimals', 'Decimals'); ?></th>
                <th><?php echo language::translate('title_prefix', 'Prefix'); ?></th>
                <th><?php echo language::translate('title_suffix', 'Suffix'); ?></th>
                <th><?php echo language::translate('title_default_currency', 'Default Currency'); ?></th>
                <th><?php echo language::translate('title_store_currency', 'Store Currency'); ?></th>
                <th><?php echo language::translate('title_priority', 'Priority'); ?></th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($currencies as $currency) { ?>
                <tr class="<?php echo empty($currency['status']) ? 'semi-transparent' : ''; ?>">
                    <td><?php echo functions::form_draw_checkbox('currencies[]', $currency['id']); ?></td>
                    <td><?php echo functions::draw_fonticon('fa-circle', 'style="color: ' . $currency['status_color'] . ';"'); ?></td>
                    <td><?php echo $currency['id']; ?></td>
                    <td><?php echo $currency['code']; ?></td>
                    <td><a class="link" href="<?php echo document::href_link('', ['doc' => 'edit_currency', 'currency_code' => $currency['code']], true); ?>"><?php echo $currency['name']; ?></a></td>
                    <td class="text-end"><?php echo language::number_format($currency['value'], 4); ?></td>
                    <td class="text-center"><?php echo $currency['decimals']; ?></td>
                    <td class="text-center"><?php echo $currency['prefix']; ?></td>
                    <td class="text-center"><?php echo $currency['suffix']; ?></td>
                    <td class="text-center"><?php echo ($currency['code'] == settings::get('default_currency_code')) ? functions::draw_fonticon('fa-check') : ''; ?></td>
                    <td class="text-center"><?php echo ($currency['code'] == settings::get('store_currency_code')) ? functions::draw_fonticon('fa-check') : ''; ?></td>
                    <td class="text-center"><?php echo $currency['priority']; ?></td>
                    <td><a class="btn btn-default btn-sm" href="<?php echo document::href_link('', ['doc' => 'edit_currency', 'currency_code' => $currency['code']], true); ?>" title="<?php echo functions::escape_html(language::translate('title_edit', 'Edit')); ?>"><?php echo functions::draw_fonticon('fa-pencil'); ?></a></td>
                </tr>
            <?php } ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="13"><?php echo language::translate('title_currencies', 'Currencies'); ?>: <?php echo $num_rows; ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="card-body">
        <fieldset id="actions" disabled>
            <legend><?php echo language::translate('text_with_selected', 'With selected'); ?>:</legend>

            <div class="btn-group">
                <?php echo functions::form_draw_button('enable', language::translate('title_enable', 'Enable'), 'submit', '', 'on'); ?>
                <?php echo functions::form_draw_button('disable', language::translate('title_disable', 'Disable'), 'submit', '', 'off'); ?>
            </div>
        </fieldset>
    </div>

    <?php echo functions::form_draw_form_end(); ?>

    <?php if ($num_pages > 1) { ?>
        <div class="card-footer">
            <?php echo functions::draw_pagination($num_pages); ?>
        </div>
    <?php } ?>
</div>

<script>
    $('.data-table input[name^="currencies["]').change(function() {
        if ($('.data-table input[name^="currencies["]:checked').length > 0) {
            $('fieldset').prop('disabled', false);
        } else {
            $('fieldset').prop('disabled', true);
        }
    }).trigger('change');
</script>