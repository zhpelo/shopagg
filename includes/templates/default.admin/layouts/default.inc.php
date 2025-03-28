<!DOCTYPE html>
<html lang="{snippet:language}" dir="{snippet:text_direction}" <?php echo !empty($_COOKIE['dark_mode']) ? ' class="dark-mode"' : ''; ?>>

<head>
    <title>{snippet:title}</title>
    <meta charset="{snippet:charset}">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=1600">
    <link rel="stylesheet" href="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'css/variables.css'); ?>">
    <link rel="stylesheet" href="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'css/framework.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'css/app.min.css'); ?>">
    {snippet:head_tags}
    {snippet:style}
    <style>
        :root {
            --default-text-size: <?php echo !empty($_COOKIE['font_size']) ? $_COOKIE['font_size'] : '14'; ?>px;
        }
    </style>
</head>

<body>

    <div id="backend-wrapper">
        <input id="sidebar-compressed" type="checkbox" hidden>

        <div id="sidebar" class="hidden-print">

            <div id="logotype">
                <a href="<?php echo document::href_link(WS_DIR_ADMIN); ?>">
                    <img class="responsive" src="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'images/shopagg-logo.png'); ?>" alt="<?php echo settings::get('store_name'); ?>">
                </a>
            </div>

            <div id="search">
                <?php echo functions::form_draw_search_field('query', false, 'placeholder="' . functions::escape_html(language::translate('title_search', 'Search')) . '&hellip;" autocomplete="off"'); ?>
                <div class="results"></div>
            </div>

            {snippet:box_apps_menu}

            <div id="platform" class="text-center">
                <a href="<?php echo document::href_link(WS_DIR_ADMIN . 'about.php'); ?>">
                    <?php echo PLATFORM_NAME; ?>
                </a>
                <div>
                    <small style="color: #a3a3a3"><?php echo PLATFORM_VERSION; ?></small>
                </div>
            </div>
        </div>

        <main id="main">
            <ul id="top-bar" class="hidden-print">
                <li>
                    <div>
                        <label class="nav-toggle" for="sidebar-compressed">
                            <?php echo functions::draw_fonticon('fa-bars'); ?>
                        </label>
                    </div>
                </li>

                <li>
                    {snippet:breadcrumbs}
                </li>

                <li style="flex-grow: 1;"></li>

                <li>
                    <div class="btn-group btn-group-inline" data-toggle="buttons">
                        <button name="font_size" class="btn btn-default btn-sm" type="button" value="decrease"><span style="font-size: .8em;">A</span></button>
                        <button name="font_size" class="btn btn-default btn-sm" type="button" value="increase"><span style="font-size: 1.25em;">A</span></button>
                    </div>
                </li>

                <li>
                    <div class="btn-group btn-group-inline" data-toggle="buttons">
                        <label class="btn btn-default btn-sm<?php echo empty($_COOKIE['dark_mode']) ? ' active' : ''; ?>" title="<?php echo functions::escape_html(language::translate('title_light', 'Light')); ?>"><input type="radio" name="dark_mode" value="0" <?php echo empty($_COOKIE['dark_mode']) ? ' checked' : ''; ?> /> <?php echo functions::draw_fonticon('fa-sun-o'); ?></label>
                        <label class="btn btn-default btn-sm<?php echo !empty($_COOKIE['dark_mode']) ? ' active' : ''; ?>" title="<?php echo functions::escape_html(language::translate('title_dark', 'Dark')); ?>"><input type="radio" name="dark_mode" value="1" <?php echo !empty($_COOKIE['dark_mode']) ? ' checked' : ''; ?> /> <?php echo functions::draw_fonticon('fa-moon-o'); ?></label>
                    </div>
                </li>

                <li class="language dropdown">
                    <a href="#" data-toggle="dropdown"><span style="font-family: monospace" title="<?php echo functions::escape_html(language::$selected['name']); ?>"><?php echo language::$selected['code']; ?><span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php foreach (language::$languages as $language) { ?>
                            <li>
                                <a href="<?php echo document::href_link(null, ['language' => $language['code']]); ?>">
                                    <?php echo $language['name']; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>

                <?php if ($webmail_link = settings::get('webmail_link')) { ?>
                    <li>
                        <a href="<?php echo ($webmail_link != 'https://') ? functions::escape_html($webmail_link) : document::href_link(WS_DIR_ADMIN, ['app' => 'settings', 'doc' => 'advanced', 'key' => 'webmail_link', 'action' => 'edit']); ?>" target="_blank" title="<?php echo language::translate('title_webmail', 'Webmail'); ?>">
                            <?php echo functions::draw_fonticon('fa-envelope'); ?>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($control_panel_link = settings::get('control_panel_link')) { ?>
                    <li>
                        <a href="<?php echo ($control_panel_link != 'https://') ? functions::escape_html($control_panel_link) : document::href_link(WS_DIR_ADMIN, ['app' => 'settings', 'doc' => 'advanced', 'key' => 'control_panel_link', 'action' => 'edit']); ?>" target="_blank" title="<?php echo language::translate('title_control_panel', 'Control Panel'); ?>">
                            <?php echo functions::draw_fonticon('fa-cogs'); ?>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($database_admin_link = settings::get('database_admin_link')) { ?>
                    <li>
                        <a href="<?php echo ($database_admin_link != 'https://') ? functions::escape_html($database_admin_link) : document::href_link(WS_DIR_ADMIN, ['app' => 'settings', 'doc' => 'advanced', 'key' => 'database_admin_link', 'action' => 'edit']); ?>" target="_blank" title="<?php echo language::translate('title_database_manager', 'Database Manager'); ?>">
                            <?php echo functions::draw_fonticon('fa-database'); ?>
                        </a>
                    </li>
                <?php } ?>

                <li>
                    <a href="<?php echo document::href_ilink(''); ?>" title="<?php echo functions::escape_html(language::translate('title_frontend', 'Frontend')); ?>">
                        <?php echo functions::draw_fonticon('fa-desktop'); ?> <?php echo language::translate('title_frontend', 'Frontend'); ?>
                    </a>
                </li>

                <li>
                    <a class="help" href="https://shopagg.org/" target="_blank" title="<?php echo functions::escape_html(language::translate('title_help', 'Help')); ?>">
                        <?php echo functions::draw_fonticon('fa-question-circle'); ?> <?php echo language::translate('title_help', 'Help'); ?>
                    </a>
                </li>

                <li>
                    <a href="<?php echo document::href_link(WS_DIR_ADMIN . 'logout.php'); ?>" title="<?php echo functions::escape_html(language::translate('title_sign_out', 'Sign Out')); ?>">
                        <?php echo functions::draw_fonticon('fa-sign-out'); ?> <?php echo language::translate('title_sign_out', 'Sign Out'); ?>
                    </a>
                </li>
            </ul>

            <div id="content">
                {snippet:notices}
                {snippet:content}
            </div>
        </main>
    </div>

    {snippet:foot_tags}
    <script src="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'js/app.min.js'); ?>"></script>
    {snippet:javascript}

    <script>
        $('button[name="font_size"]').click(function() {
            let new_size = parseInt($(':root').css('--default-text-size').split('px')[0]) + (($(this).val() == 'increase') ? 1 : -1);
            $(':root').css('--default-text-size', new_size + 'px');
            document.cookie = 'font_size=' + new_size + ';Path=<?php echo WS_DIR_APP; ?>;Max-Age=2592000';
        });

        $('input[name="dark_mode"]').click(function() {
            if ($(this).val() == 1) {
                document.cookie = 'dark_mode=1;Path=<?php echo WS_DIR_APP; ?>;Max-Age=2592000';
                $('html').addClass('dark-mode');
            } else {
                document.cookie = 'dark_mode=0;Path=<?php echo WS_DIR_APP; ?>;Max-Age=2592000';
                $('html').removeClass('dark-mode');
            }
        });
    </script>
</body>

</html>