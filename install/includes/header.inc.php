<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SHOPAGG Installer</title>
    <link rel="stylesheet" href="../includes/templates/default.catalog/css/variables.css">
    <?php if (is_file(__DIR__ . '/../../includes/templates/default.catalog/css/framework.css')) { ?>
        <link rel="stylesheet" href="../includes/templates/default.catalog/css/framework.css">
    <?php } else { ?>
        <link rel="stylesheet" href="../includes/templates/default.catalog/css/framework.min.css">
    <?php } ?>
    <style>
        html {
            background: radial-gradient(ellipse at center, #fff 20%, #d2d7de 100%);
        }

        body {
            padding: 15px;
        }

        #logotype {
            max-width: 300px;
            max-height: 100px;
            margin-bottom: 2em;
        }

        .glass-edges {
            margin: 0 auto;
            margin-bottom: 15px;
            padding: 15px;
            max-width: 800px;
            border: 1px solid rgba(128, 128, 128, 0.5);
            border-radius: 30px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5), inset 0 1px rgba(255, 255, 255, 0.3), inset 0 10px rgba(255, 255, 255, 0.2), inset 0 10px 20px rgba(255, 255, 255, 0.25), inset 0 -15px 30px rgba(0, 0, 0, 0.3);
        }

        #content {
            padding: 20px;
            background-color: #fff;
            border: 1px rgba(128, 128, 128, 0.5) solid;
            border-radius: 20px;
        }

        span.ok {
            color: #0c0;
            font-weight: bold;
        }

        span.error {
            color: #f00;
            font-weight: bold;
        }

        span.warning {
            color: #c60;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="glass-edges">
        <main id="content">
            <header class="text-center">
                <img id="logotype" src="../includes/templates/default.admin/images/shopagg-logo.png" alt="SHOPAGG">
            </header>