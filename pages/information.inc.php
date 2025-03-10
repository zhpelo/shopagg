<?php

try {

    if (empty($_GET['page_id'])) throw new Exception('Missing page_id', 400);

    $page = reference::page($_GET['page_id']);

    if (empty($page->id)) {
        http_response_code(410);
        include vmod::check(FS_DIR_APP . 'pages/error_document.inc.php');
        return;
    }

    if (empty($page->status)) {
        http_response_code(404);
        include vmod::check(FS_DIR_APP . 'pages/error_document.inc.php');
        return;
    }

    $mother_page = array_values($page->path)[0];
    if ($mother_page->dock == 'customer_service') {
        http_response_code(301);
        header('Location: ' . document::ilink('customer_service', ['page_id' => $page->id]));
        exit;
    }

    document::$snippets['title'][] = !empty($page->head_title) ? $page->head_title : $page->title;
    document::$snippets['description'] = !empty($page->meta_description) ? $page->meta_description : '';
    document::$snippets['canonical'] = '<link rel="canonical" href="' . document::ilink('information', ['page_id' => $page->id]) . '">';

    if ($page->dock == 'information') {
        breadcrumbs::add(language::translate('title_information', 'Information'));
    }

    foreach (array_slice($page->path, 0, -1, true) as $crumb) {
        breadcrumbs::add($crumb->title, document::ilink('information', ['page_id' => $crumb->id]));
    }
    breadcrumbs::add($page->title);

    $_page = new ent_view();

    $_page->snippets = [
        'title' => $page->title,
        'content' => $page->content,
    ];

    if ($page->dock == 'information') {
        echo $_page->stitch('pages/information');
    } else {
        echo $_page->stitch('pages/page');
    }
} catch (Exception $e) {
    http_response_code($e->getCode());
    //notices::add('errors', $e->getMessage());
    include vmod::check(FS_DIR_APP . 'pages/error_document.inc.php');
    return;
}
