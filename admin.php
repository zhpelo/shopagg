<?php
require_once 'functions.php';

// 检查管理员登录状态
if (!isset($_SESSION['admin'])) {
    header("Location: index.php"); // 未登录则跳转前台
    exit;
}

// 显示消息或错误（同前台）
function showMessage() { /* 同 index.php */ }
?>

<!DOCTYPE html>
<html>
<head>
    <title>后台管理</title>
    <style>/* 同前台样式 */</style>
</head>
<body>
    <?php showMessage(); ?>

    <h1>后台管理</h1>
    
    <!-- 添加商品表单 -->
    <h2>添加商品</h2>
    <form method="post" action="functions.php">
        <input type="hidden" name="action" value="add_product">
        <input type="text" name="name" placeholder="商品名称" required>
        <textarea name="description" placeholder="商品描述" required></textarea>
        <input type="number" name="price" step="0.01" placeholder="价格" required>
        <button>提交</button>
    </form>

    <!-- 网站设置 -->
    <h2>网站设置</h2>
    <?php $settings = getSettings(); ?>
    <form method="post" action="functions.php">
        <input type="hidden" name="action" value="update_settings">
        <input type="text" name="site_name" value="<?= $settings['site_name'] ?>" required>
        <textarea name="site_description" required><?= $settings['site_description'] ?></textarea>
        <input type="email" name="site_email" value="<?= $settings['site_email'] ?>" required>
        <button>保存设置</button>
    </form>
</body>
</html>