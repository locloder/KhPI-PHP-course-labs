<?php
<?php

// --- Крок 1: Створення базового класу Product ---

class Product
{
    // Публічний доступ (доступний скрізь)
    public string $name;
    public string $description;

    // Захищений доступ (доступний у цьому класі та дочірніх класах)
    protected float $price;

    /**
     * Конструктор класу Product.
     * @param string $name Назва товару
     * @param float $price Ціна товару
     * @param string $description Опис товару
     */
    public function __construct(string $name, float $price, string $description)
    {
        $this->name = $name;
        $this->description = $description;
        $this->setPrice($price); // Використовуємо сеттер для валідації ціни
    }

    /**
     * Встановлює ціну, виконуючи валідацію (ціна не може бути від'ємною).
     * @param float $price Нова ціна
     */
    protected function setPrice(float $price): void
    {
        if ($price < 0) {
            // Встановлюємо 0 або кидаємо виняток, залежно від вимог
            echo "Помилка: Ціна товару '{$this->name}' не може бути від'ємною. Встановлено 0. <br>";
            $this->price = 0.0;
        } else {
            $this->price = $price;
        }
    }

    /**
     * Отримує захищену ціну.
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Метод для виведення інформації про товар.
     */
    public function getInfo(): void
    {
        echo "<h4>Інформація про товар:</h4>";
        echo "Назва: **" . $this->name . "**<br>";
        echo "Ціна: **" . number_format($this->price, 2) . " грн**<br>";
        echo "Опис: " . $this->description . "<br>";
    }
}

// --- Крок 2: Спадкування та розширення функціоналу ---

class DiscountedProduct extends Product
{
    // Додаткова властивість для знижки
    public int $discount; // Знижка у відсотках (наприклад, 15)

    /**
     * Конструктор класу DiscountedProduct.
     * Ініціалізує батьківський клас та встановлює знижку.
     */
    public function __construct(string $name, float $price, string $description, int $discount)
    {
        // Виклик конструктора батьківського класу Product
        parent::__construct($name, $price, $description);
        
        $this->discount = $discount;
    }

    /**
     * Розрахунок нової ціни з урахуванням знижки.
     * @return float Нова ціна
     */
    public function getDiscountedPrice(): float
    {
        // Доступ до захищеної властивості $price через успадкування
        return $this->price * (1 - $this->discount / 100);
    }

    /**
     * Перевизначений метод для виведення інформації про товар зі знижкою.
     */
    public function getInfo(): void
    {
        // Виклик батьківського методу для базової інформації
        parent::getInfo();

        $discountedPrice = $this->getDiscountedPrice();

        echo "Знижка: **" . $this->discount . "%**<br>";
        echo "Нова ціна: **" . number_format($discountedPrice, 2) . " грн**<br>";
    }
}

// --- Завдання: Реалізація класу Category ---

class Category
{
    public string $name;
    private array $products = []; // Масив для зберігання об'єктів Product або DiscountedProduct

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Метод для додавання товару до категорії.
     * @param Product $product Об'єкт класу Product або його дочірнього класу.
     */
    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
        echo "Товар '{$product->name}' додано до категорії '{$this->name}'.<br>";
    }

    /**
     * Метод для виведення всіх товарів категорії.
     */
    public function listProducts(): void
    {
        echo "<h2>Категорія: **{$this->name}**</h2>";
        
        if (empty($this->products)) {
            echo "<p>У цій категорії немає товарів.</p>";
            return;
        }

        foreach ($this->products as $product) {
            echo "<div style='border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>";
            // Викликаємо метод getInfo() для кожного об'єкта
            $product->getInfo();
            echo "</div>";
        }
    }
}

// --- Крок 3: Створення та тестування об'єктів ---

echo "<h1>Тестування системи інтернет-магазину (ООП)</h1>";
echo "<hr>";

// 1. Створення об'єктів класу Product
$book = new Product(
    "PHP: Об'єктно-орієнтоване програмування",
    450.00,
    "Детальний посібник з ООП в PHP."
);

$keyboard = new Product(
    "Механічна клавіатура HyperX",
    2599.99,
    "Ігрова клавіатура з RGB-підсвіткою."
);

// Тест валідації ціни
$invalid_product = new Product(
    "Тестовий товар з помилкою",
    -100.00, // Від'ємна ціна
    "Цей товар має перевірити валідацію ціни."
);

// 2. Створення об'єкта класу DiscountedProduct
$laptop = new DiscountedProduct(
    "Ноутбук Dell XPS 15",
    45000.00,
    "Потужний ноутбук для розробки.",
    15 // Знижка 15%
);

$monitor = new DiscountedProduct(
    "Монітор 27' 4K",
    12000.00,
    "Якісний монітор для професійної роботи.",
    20 // Знижка 20%
);

echo "<h2>1. Тестування окремих товарів</h2>";
$book->getInfo();
echo "<br>";

$laptop->getInfo();
echo "<br>";

$invalid_product->getInfo();
echo "<hr>";


// 3. Тестування класу Category
$electronics_category = new Category("Електроніка");
$books_category = new Category("Книги та Навчальні матеріали");

// Додавання товарів до категорій
$electronics_category->addProduct($keyboard);
$electronics_category->addProduct($laptop);
$electronics_category->addProduct($monitor);
echo "<br>";

$books_category->addProduct($book);
echo "<br>";


// Виведення всіх товарів у категорії
$electronics_category->listProducts();
$books_category->listProducts();

?>
