# PHP 简易商城系统

一个基于 PHP 和 MySQL 构建的简易商城系统，实现前后台分离设计，适合学习或快速搭建基础电商平台。

## 🛠️ 功能列表

### 前台用户功能
- **用户注册/登录/找回密码**
- 商品浏览与详细信息展示
- 商品购买及订单提交
- 基础会话管理（登录状态保持）

### 后台管理功能
- 管理员登录验证
- 商品发布与管理
- 网站基本信息设置（名称、描述、联系邮箱）
- 订单查看（需在代码中扩展界面）

## 🚀 快速开始

### 环境要求
- PHP ≥7.0 
- MySQL ≥5.7
- Web服务器（如Apache/Nginx）

### 安装步骤

1. **导入数据库**
```sql
CREATE DATABASE shop;
USE shop;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1,	'admin',	'$2y$10$UldMemPvh.gMzJtFF1KDMenzprTpGB0No.IhGdBBUEPEO3iRkaGd6',	'admin@qq.com',	'2025-02-25 20:53:21');


CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);


-- 运行之前对话中提供的完整SQL表结构
```

2. **配置文件修改**
```php
// 修改 functions.php 中的数据库配置
$host = 'localhost';
$dbname = 'shop';
$user = 'your_db_user';
$pass = 'your_db_password';
```

3. **部署文件**
```
将以下文件放入Web根目录：
- functions.php
- index.php
- admin.php
```

### 访问方式
- **前台地址**: `http://your-domain.com/index.php`
- **后台地址**: `http://your-domain.com/admin.php`
  - 管理员账号: `admin` / `123456` (请在生产环境中修改)

## 📁 项目结构
```
├── functions.php    # 核心逻辑（数据库/业务处理）
├── index.php        # 用户前台界面
└── admin.php        # 管理后台界面
```

## 🔧 技术特性
- PHP 面向过程开发
- MySQL 数据库存储
- 会话管理（Session）
- 基础安全防护：
  - 密码哈希存储（password_hash）
  - SQL 注入防护（预处理语句）
  - XSS 防护（htmlspecialchars输出转义）

## ⚠️ 重要注意事项
1. **安全警告**  
当前版本为教学演示用，生产环境需额外增强：
   - 添加CSRF令牌保护
   - 实现完整的支付接口（如PayPal）
   - 加强管理员密码策略

2. **待实现功能**
   - 订单历史查看界面
   - 用户密码重置邮件功能
   - 商品图片上传支持
   - 支付系统集成

3. **配置建议**
   - 修改 `admin.php` 中的硬编码管理员凭证
   - 定期备份数据库
   - 启用HTTPS加密传输

## 📜 开源协议
[MIT License](LICENSE) 开源，保留署名权利。可用于学习/二次开发，禁止直接用于商业盈利项目。