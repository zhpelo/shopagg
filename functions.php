<?php
session_start();

// 数据库连接
$host = 'localhost';
$dbname = 'shop';
$user = 'root';
$pass = 'root';
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// 处理用户动作
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'register': registerUser(); break;
            case 'login': loginUser(); break;
            case 'forgot_password': handleForgotPassword(); break;
            case 'purchase': purchaseProduct(); break;
            case 'admin_login': adminLogin(); break;
            case 'add_product': addProduct(); break;
            case 'update_settings': updateSettings(); break;
        }
    }
}

// ------------------------- 用户功能函数 -------------------------
function registerUser() {
    global $conn;
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $conn->real_escape_string($_POST['email']);
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);
    if ($stmt->execute()) {
        $_SESSION['message'] = "注册成功！";
    } else {
        $_SESSION['error'] = "错误：" . $stmt->error;
    }
}

function loginUser() {
    global $conn;
    $username = $conn->real_escape_string($_POST['username']);
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    if ($stmt->fetch() && password_verify($_POST['password'], $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['message'] = "登录成功！";
    } else {
        $_SESSION['error'] = "用户名或密码错误！";
    }
}

// ------------------------- 商品和订单功能 -------------------------
function getProducts() {
    global $conn;
    $result = $conn->query("SELECT * FROM products");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function purchaseProduct() {
    global $conn;
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "请先登录！";
        return;
    }
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $product = $conn->query("SELECT price FROM products WHERE id = $product_id")->fetch_assoc();
    $total_price = $product['price'] * $quantity;
    $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $user_id, $product_id, $quantity, $total_price);
    if ($stmt->execute()) {
        $_SESSION['message'] = "订单提交成功！";
    } else {
        $_SESSION['error'] = "错误：" . $stmt->error;
    }
}

// ------------------------- 后台管理功能 -------------------------
function adminLogin() {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
        $_SESSION['admin'] = true;
        $_SESSION['message'] = "管理员登录成功！";
    } else {
        $_SESSION['error'] = "管理员凭证无效！";
    }
}

function addProduct() {
    global $conn;
    if (!isset($_SESSION['admin'])) return;
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $conn->query("INSERT INTO products (name, description, price) VALUES ('$name', '$description', $price)");
    $_SESSION['message'] = "商品添加成功！";
}

// ------------------------- 其他辅助函数 -------------------------
function getSettings() {
    global $conn;
    return $conn->query("SELECT * FROM settings WHERE id = 1")->fetch_assoc();
}
?>