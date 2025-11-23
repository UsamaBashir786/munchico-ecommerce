<?php
// cart.php - Simple shopping cart page
// Assumes product items are stored in $_SESSION['cart'] as an array of items with keys:
// id, name, price, qty, image (optional)

session_start();

// Simple helper functions
function get_cart(): array {
    return isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];
}

function save_cart(array $cart): void {
    $_SESSION['cart'] = $cart;
}

function sanitize_int($v, $default = 0) {
    $v = filter_var($v, FILTER_VALIDATE_INT);
    return $v === false ? $default : $v;
}

function format_money($amount) {
    return number_format((float)$amount, 2);
}

$messages = [];

// Handle POST actions: update quantities, remove item, clear cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $cart = get_cart();

    if ($action === 'update') {
        // Expect quantities in POST as qty[<id>] = <int>
        $quantities = $_POST['qty'] ?? [];
        foreach ($cart as &$item) {
            $id = $item['id'] ?? null;
            if ($id !== null && isset($quantities[$id])) {
                $newQty = sanitize_int($quantities[$id], $item['qty'];
                if ($newQty <= 0) {
                    // remove item
                    $item['qty'] = 0;
                } else {
                    $item['qty'] = $newQty;
                }
            }
        }
        unset($item);
        // Remove items with qty <= 0
        $cart = array_filter($cart, function($it){ return isset($it['qty']) && $it['qty'] > 0; });
        save_cart(array_values($cart));
        $messages[] = 'Cart updated.';
    } elseif ($action === 'remove') {
        $removeId = $_POST['remove_id'] ?? null;
        if ($removeId !== null) {
            $cart = array_filter($cart, function($it) use ($removeId){ return ($it['id'] ?? '') != $removeId; });
            save_cart(array_values($cart));
            $messages[] = 'Item removed from cart.';
        }
    } elseif ($action === 'clear') {
        unset($_SESSION['cart']);
        $messages[] = 'Cart cleared.';
    }
}

// Calculate totals
$cart = get_cart();
$subtotal = 0.0;
foreach ($cart as $item) {
    $price = isset($item['price']) ? (float)$item['price'] : 0.0;
    $qty = isset($item['qty']) ? (int)$item['qty'] : 0;
    $subtotal += $price * $qty;
}

// Example: tax 5%, shipping free over 50
$taxRate = 0.05;
$tax = $subtotal * $taxRate;
$shipping = $subtotal > 50 || $subtotal == 0 ? 0.0 : 5.00;
total = $subtotal + $tax + $shipping;\n
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping Cart</title>
    <style>
        /* Minimal styles for the cart page - override with your site's CSS as needed */
        body { font-family: Arial, Helvetica, sans-serif; margin: 20px; color: #333; }
        .container { max-width: 980px; margin: 0 auto; }
        h1 { margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th, td { padding: 10px; border-bottom: 1px solid #e6e6e6; text-align: left; }
        th { background: #fafafa; }
        .product-img { width: 70px; height: 70px; object-fit: cover; border: 1px solid #ddd; }
        .qty-input { width: 64px; }
        .actions { display: flex; gap: 8px; }
        .btn { padding: 8px 12px; border: 1px solid #007bff; background: #007bff; color: #fff; text-decoration: none; cursor: pointer; border-radius: 4px; }
        .btn.secondary { background: #6c757d; border-color: #6c757d; }
        .btn.ghost { background: transparent; color: #007bff; border-color: transparent; }
        .text-right { text-align: right; }
        .totals { float: right; width: 320px; border: 1px solid #eee; padding: 12px; border-radius: 6px; background: #fafafa; }
        .totals div { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .empty { text-align: center; padding: 30px 0; color: #666; }
        .message { background: #e6f7e6; border: 1px solid #bfe6bf; padding: 8px 12px; border-radius: 4px; margin-bottom: 12px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Your Cart</h1>

    <?php foreach ($messages as $m): ?>
        <div class="message"><?php echo htmlspecialchars($m); ?></div>
    <?php endforeach; ?>

    <?php if (empty($cart)): ?>
        <div class="empty">
            <p>Your cart is empty.</p>
            <p><a class="btn" href="/">Continue shopping</a></p>
        </div>
    <?php else: ?>
        <form method="post" action="cart.php">
            <input type="hidden" name="action" value="update">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-right">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item):
                        $id = $item['id'] ?? '';
                        $name = $item['name'] ?? 'Product';
                        $price = isset($item['price']) ? (float)$item['price'] : 0.0;
                        $qty = isset($item['qty']) ? (int)$item['qty'] : 0;
                        $img = $item['image'] ?? '';
                        $lineTotal = $price * $qty;
                    ?>
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <?php if ($img): ?>
                                    <img src="<?php echo htmlspecialchars($img); ?>" alt="" class="product-img">
                                <?php endif; ?>
                                <div><?php echo htmlspecialchars($name); ?></div>
                            </div>
                        </td>
                        <td>$<?php echo format_money($price); ?></td>
                        <td>
                            <input class="qty-input" type="number" min="0" name="qty[<?php echo htmlspecialchars($id); ?>]" value="<?php echo htmlspecialchars($qty); ?>">
                        </td>
                        <td class="text-right">$<?php echo format_money($lineTotal); ?></td>
                        <td class="text-right">
                            <div class="actions">
                                <form method="post" action="cart.php" style="display:inline;">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="remove_id" value="<?php echo htmlspecialchars($id); ?>">
                                    <button class="btn ghost" type="submit">Remove</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;">
                <div>
                    <button class="btn" type="submit">Update Cart</button>
                    <button class="btn secondary" type="button" onclick="if(confirm('Clear the cart?')){document.getElementById('clearForm').submit();}">Clear Cart</button>
                </div>
                <div class="totals">
                    <div><strong>Subtotal</strong><span>$<?php echo format_money($subtotal); ?></span></div>
                    <div><strong>Tax (<?php echo ($taxRate*100); ?>%)</strong><span>$<?php echo format_money($tax); ?></span></div>
                    <div><strong>Shipping</strong><span>$<?php echo format_money($shipping); ?></span></div>
                    <hr>
                    <div style="font-size:1.15em;"><strong>Total</strong><span>$<?php echo format_money($total); ?></span></div>
                    <div style="margin-top:8px;text-align:right;"><a class="btn" href="checkout.php">Proceed to Checkout</a></div>
                </div>
            </div>
        </form>

        <form id="clearForm" method="post" action="cart.php" style="display:none;">
            <input type="hidden" name="action" value="clear">
        </form>
    <?php endif; ?>

</div>
</body>
</html>
