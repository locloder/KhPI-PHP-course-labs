<?php
session_start();

$items = [
    'item1' => 'Книга',
    'item2' => 'Ноутбук',
    'item3' => 'Телефон',
    'item4' => 'Навушники'
];

if (isset($_GET['add'])) {
    $item_id = $_GET['add'];
    if (isset($items[$item_id])) {
        $_SESSION['cart'][] = $items[$item_id];
    }
    header('Location: 4_cart.php');
    exit;
}

if (isset($_GET['clear'])) {
    if (isset($_SESSION['cart'])) {
        $previous_purchases = isset($_COOKIE['previous_purchases']) ? json_decode($_COOKIE['previous_purchases'], true) : [];
        $previous_purchases = array_merge($previous_purchases, $_SESSION['cart']);
        setcookie('previous_purchases', json_encode($previous_purchases), time() + (30 * 24 * 60 * 60)); // 30 днів

        unset($_SESSION['cart']);
    }
    header('Location: 4_cart.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Кошик та Історія покупок</title>
</head>
<body>
    <h2>Кошик покупок (SESSION)</h2>
    <p>Товари в кошику:</p>
    <ul>
        <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                echo '<li>' . htmlspecialchars($item) . '</li>';
            }
            echo '</ul><a href="?clear">Оформити замовлення (очистити кошик)</a>';
        } else {
            echo '<li>Кошик порожній.</li></ul>';
        }
        ?>
    </ul>

    <h3>Додати товари:</h3>
    <ul>
        <?php foreach ($items as $id => $name): ?>
            <li><a href="?add=<?php echo $id; ?>"><?php echo htmlspecialchars($name); ?></a></li>
        <?php endforeach; ?>
    </ul>

    <hr>
    <h2>Попередні покупки (COOKIE)</h2>
    <ul>
        <?php
        if (isset($_COOKIE['previous_purchases'])) {
            $prev_items = json_decode($_COOKIE['previous_purchases'], true);
            if (!empty($prev_items)) {
                $prev_items_unique = array_unique($prev_items);
                foreach ($prev_items_unique as $item) {
                    echo '<li>' . htmlspecialchars($item) . '</li>';
                }
            } else {
                echo '<li>Історія порожня.</li>';
            }
        } else {
            echo '<li>Історія порожня.</li>';
        }
        ?>
    </ul>
</body>
</html>