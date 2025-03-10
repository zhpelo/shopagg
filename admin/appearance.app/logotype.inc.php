<?php

document::$snippets['title'][] = language::translate('title_logotype', 'Logotype');

breadcrumbs::add(language::translate('title_appearance', 'Appearance'));
breadcrumbs::add(language::translate('title_logotype', 'Logotype'));

if (isset($_POST['save'])) {

    try {
        if (empty($_FILES['image'])) {
            throw new Exception(language::translate('error_missing_image', 'You must select an image'));
        }

        if (!is_uploaded_file($_FILES['image']['tmp_name']) || !empty($_FILES['image']['error'])) {
            throw new Exception(language::translate('error_uploaded_image_rejected', 'An uploaded image was rejected for unknown reason'));
        }

        $image = new ent_image($_FILES['image']['tmp_name']);
        if (!$image->width()) throw new Exception(language::translate('error_invalid_image', 'The image is invalid'));

        $filename = 'shopagg-logo.png';

        if (is_file(FS_DIR_STORAGE . 'images/' . $filename)) unlink(FS_DIR_STORAGE . 'images/' . $filename);
        functions::image_delete_cache(FS_DIR_STORAGE . 'images/' . $filename);

        if (settings::get('image_downsample_size')) {
            list($width, $height) = explode(',', settings::get('image_downsample_size'));
            $image->resample($width, $height, 'FIT_ONLY_BIGGER');
        }

        if (!$image->write(FS_DIR_STORAGE . 'images/' . $filename)) {
            throw new Exception(language::translate('error_failed_uploading_image', 'The uploaded image failed saving to disk. Make sure permissions are set.'));
        }

        notices::add('success', language::translate('success_logotype_saved', 'Changes saved successfully. Your browser may still show the old logotype due to cache.'));
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
            <?php echo $app_icon; ?> <?php echo language::translate('title_logotype', 'Logotype'); ?>
        </div>
    </div>

    <div class="card-body">
        <?php echo functions::form_draw_form_begin('logotype_form', 'post', false, true, 'style="max-width: 480px;"'); ?>

        <img class="thumbnail" src="<?php echo document::href_rlink(FS_DIR_STORAGE . functions::image_thumbnail(FS_DIR_STORAGE . 'images/shopagg-logo.png', 500, 500, 'FIT_ONLY_BIGGER')); ?>" alt="" style="padding: 1em;">

        <div class="form-group">
            <label><?php echo language::translate('title_new_image', 'New Image'); ?></label>
            <?php echo functions::form_draw_file_field('image'); ?>
        </div>

        <div>
            <?php echo functions::form_draw_button('save', language::translate('title_save', 'Save'), 'submit', 'class="btn btn-success"', 'save'); ?>
            <?php echo functions::form_draw_button('cancel', language::translate('title_cancel', 'Cancel'), 'button', 'onclick="history.go(-1);"', 'cancel'); ?>
        </div>

        <?php echo functions::form_draw_form_end(); ?>
    </div>
</div>