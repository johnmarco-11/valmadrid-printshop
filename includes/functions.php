<?php
require_once __DIR__ . '/../config/database.php';

function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function money($amount) { return 'PHP ' . number_format((float)$amount, 2); }
function base_url($path = '') { return (getenv('BASE_PATH') ?: '/valmadrid-printshop/') . ltrim($path, '/'); }

function redirect($url) { header('Location: ' . $url); exit; }

function require_customer() {
    if (empty($_SESSION['customer_id'])) redirect(base_url('customer/login.php'));
}

function require_admin() {
    if (empty($_SESSION['admin_id'])) redirect(base_url('admin/login.php'));
}

function current_customer() {
    global $pdo;
    if (empty($_SESSION['customer_id'])) return null;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['customer_id']]);
    return $stmt->fetch();
}

function status_badge($status) {
    $colors = [
        'Pending' => 'warning text-dark', 'Confirmed' => 'primary', 'Designing' => 'info text-dark',
        'Printing' => 'secondary', 'Ready for Pickup' => 'success', 'Completed' => 'dark', 'Cancelled' => 'danger'
    ];
    $class = $colors[$status] ?? 'secondary';
    return '<span class="badge bg-' . $class . '">' . e($status) . '</span>';
}

function upload_design_file($field, $orderId = null, $productId = null) {
    global $pdo;
    if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return null;
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $allowed = ['png','jpg','jpeg','pdf','psd','docx'];
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return null;
    if ($_FILES[$field]['size'] > 15 * 1024 * 1024) return null;
    if (!is_dir(__DIR__ . '/../uploads')) mkdir(__DIR__ . '/../uploads', 0777, true);
    $safeName = date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $target = __DIR__ . '/../uploads/' . $safeName;
    move_uploaded_file($_FILES[$field]['tmp_name'], $target);
    if ($orderId) {
        $stmt = $pdo->prepare('INSERT INTO uploaded_files (order_id, product_id, original_name, file_path, status) VALUES (?,?,?,?,?)');
        $stmt->execute([$orderId, $productId, $_FILES[$field]['name'], 'uploads/' . $safeName, 'For Review']);
    }
    return 'uploads/' . $safeName;
}

function cart_items() {
    global $pdo;
    if (empty($_SESSION['cart'])) return [];
    $items = [];
    foreach ($_SESSION['cart'] as $key => $row) {
        $stmt = $pdo->prepare('SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.id=? AND p.is_archived=0');
        $stmt->execute([$row['product_id']]);
        $product = $stmt->fetch();
        if ($product) {
            $product['cart_key'] = $key;
            $product['qty'] = (int)$row['qty'];
            $product['notes'] = $row['notes'] ?? '';
            $items[] = $product;
        }
    }
    return $items;
}

function cart_totals() {
    $subtotal = 0;
    foreach (cart_items() as $item) $subtotal += $item['price'] * $item['qty'];
    $fee = $subtotal > 0 ? 30 : 0;
    return ['subtotal' => $subtotal, 'fee' => $fee, 'total' => $subtotal + $fee];
}
?>