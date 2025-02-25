<?php
require_once 'functions.php'; // 引入功能文件

// 显示消息或错误
function showMessage() {
    if (isset($_SESSION['message'])) {
        echo "<div class='message'>{$_SESSION['message']}</div>";
        unset($_SESSION['message']);
    }
    if (isset($_SESSION['error'])) {
        echo "<div class='error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>商品商城</title>
    <style>
        .message { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <?php showMessage(); ?>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- 登录表单 -->
        <h2>登录</h2>
        <form method="post" action="functions.php">
            <input type="hidden" name="action" value="login">
            <input type="text" name="username" placeholder="用户名" required>
            <input type="password" name="password" placeholder="密码" required>
            <button>登录</button>
        </form>

        <!-- 注册表单 -->
        <h2>注册</h2>
        <form method="post" action="functions.php">
            <input type="hidden" name="action" value="register">
            <input type="text" name="username" placeholder="用户名" required>
            <input type="email" name="email" placeholder="邮箱" required>
            <input type="password" name="password" placeholder="密码" required>
            <button>注册</button>
        </form>
    <?php else: ?>
        <!-- 商品列表 -->
        <h2>商品列表</h2>
        <?php foreach (getProducts() as $product): ?>
            <div class="product">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p>价格：$<?= $product['price'] ?></p>
                <form method="post" action="functions.php">
                    <input type="hidden" name="action" value="purchase">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="number" name="quantity" value="1" min="1">
                    <button>购买</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>