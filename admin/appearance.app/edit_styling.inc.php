<?php

if (is_file(FS_DIR_APP . 'includes/templates/' . settings::get('store_template_catalog') . '/less/variables.less')) {
    $stylesheet = FS_DIR_APP . 'includes/templates/' . settings::get('store_template_catalog') . '/less/variables.less';
} else if (is_file(FS_DIR_APP . 'includes/templates/' . settings::get('store_template_catalog') . '/css/variables.css')) {
    $stylesheet = FS_DIR_APP . 'includes/templates/' . settings::get('store_template_catalog') . '/css/variables.css';
} else {
    notices::add('errors', language::translate('error_template_missing_variables_stylesheet', 'This template does not have an editable stylesheet with variables (e.g. variables.css)'));
    return;
}

if (!$_POST) {
    $_POST['content'] = file_get_contents($stylesheet);
}

if (!empty($_POST['save'])) {

    try {

        file_put_contents($stylesheet, $_POST['content']);

        notices::add('success', language::translate('success_changes_saved', 'Changes saved'));
        header('Location: ' . document::link());
        exit;
    } catch (Exception $e) {
        notices::add('errors', $e->getMessage());
    }
}

?>
<div class="card card-app">
    <div class="card-header">
        <div class="card-title">
            <?php echo $app_icon; ?> <?php echo language::translate('title_edit_styling', 'Edit Styling'); ?>
        </div>
    </div>

    <div class="card-body">

        <?php if (preg_match('#\.less$#', $stylesheet)) { ?>
            <div class="alerts">
                <div class="alert alert-default"><?php echo functions::draw_fonticon('fa-info fa-fw'); ?> <?php echo language::translate('notice_detected_less_version_of_variables', 'We detected a LESS version present in this installation that will be used. A LESS compiler is needed to compile the CSS versions (e.g. Developer Kit add-on).'); ?></div>
            </div>
        <?php } ?>

        <?php echo functions::form_draw_form_begin('file_form', 'post'); ?>

        <div class="form-group" style="max-width: 800px;">
            <label><?php echo language::translate('title_file', 'File'); ?></label>
            <div class="form-control" readonly><?php echo preg_replace('#^' . preg_quote(FS_DIR_APP, '#') . '#', '', $stylesheet); ?></div>
        </div>

        <div class="form-group">
            <label><?php echo language::translate('title_content', 'Content'); ?></label>
            <?php echo functions::form_draw_code_field('content', true); ?>
        </div>

        <div class="card-action">
            <?php echo functions::form_draw_button('save', language::translate('title_save', 'Save'), 'submit', 'class="btn btn-success"', 'save'); ?>
            <?php echo functions::form_draw_button('cancel', language::translate('title_cancel', 'Cancel'), 'button', 'onclick="history.go(-1);"', 'cancel'); ?>
        </div>

        <?php echo functions::form_draw_form_end(); ?>
    </div>
</div>