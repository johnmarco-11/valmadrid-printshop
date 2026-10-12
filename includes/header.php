<?php require_once __DIR__ . '/functions.php'; $customer = current_customer(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? 'Valmadrid Advertising and Digital Print') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&family=Oswald:wght@500;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top brand-nav shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="<?= base_url('index.php') ?>">
            <img src="<?= base_url('assets/images/logo.svg') ?>" alt="Valmadrid logo" width="46" height="46"> Valmadrid Print
        </a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('index.php') ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('products.php') ?>">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('about.php') ?>">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('contact.php') ?>">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('cart.php') ?>"><i class="bi bi-cart3"></i> Cart</a></li>
                <?php if ($customer): ?>
                    <li class="nav-item"><a class="btn btn-dark btn-sm ms-lg-2" href="<?= base_url('customer/dashboard.php') ?>">My Account</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-red btn-sm ms-lg-2" href="<?= base_url('customer/login.php') ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php if (!empty($_SESSION['flash'])): ?><div class="container mt-3"><div class="alert alert-info"><?= e($_SESSION['flash']); unset($_SESSION['flash']); ?></div></div><?php endif; ?>