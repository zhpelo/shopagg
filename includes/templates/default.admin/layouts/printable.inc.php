<!DOCTYPE html>
<html lang="{snippet:language}" dir="{snippet:text_direction}">

<head>
    <title>{snippet:title}</title>
    <meta charset="{snippet:charset}">
    <link rel="stylesheet" href="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'css/variables.css'); ?>">
    <link rel="stylesheet" href="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'css/framework.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo document::href_rlink(FS_DIR_TEMPLATE . 'css/printable.min.css'); ?>">
    {snippet:head_tags}
    {snippet:style}
</head>

<body>

    {snippet:content}

    {snippet:foot_tags}
    {snippet:javascript}

</body>

</html>