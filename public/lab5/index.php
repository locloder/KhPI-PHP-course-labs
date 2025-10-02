<?php

// --- Крок 1: Створення інтерфейсу для банківського рахунку ---

/**
 * Інтерфейс, який визначає основні операції для банківського рахунку.
 */
interface AccountInterface
{
    public function deposit(float $amount): void;
    public function withdraw(float $amount): void;
    public function getBalance(): float;
}

// --- Крок 2: Створення базового класу з константою та обробкою винятків ---

/**
 * Базовий клас банківського рахунку, що реалізує AccountInterface.
 */
class BankAccount implements AccountInterface
{
    // Класова константа: мінімальний дозволений баланс
    public const MIN_BALANCE = 0.0;

    protected float $balance;
    protected string $currency;

    /**
     * Конструктор класу.
     * @param float $initialBalance Початковий баланс
     * @param string $currency Валюта рахунку
     */
    public function __construct(float $initialBalance, string $currency = "UAH")
    {
        if ($initialBalance < self::MIN_BALANCE) {
            $initialBalance = self::MIN_BALANCE;
        }
        $this->balance = $initialBalance;
        $this->currency = $currency;
    }

    /**
     * Поповнення рахунку.
     * @param float $amount Сума для поповнення
     * @throws Exception Якщо сума є некоректною (негативною або нульовою).
     */
    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new Exception("Некоректна сума поповнення. Сума має бути позитивною.");
        }
        $this->balance += $amount;
        echo "Рахунок поповнено на: **" . number_format($amount, 2) . " {$this->currency}**<br>";
    }

    /**
     * Зняття коштів з рахунку.
     * @param float $amount Сума для зняття
     * @throws Exception Якщо сума є некоректною або недостатньо коштів.
     */
    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new Exception("Некоректна сума зняття. Сума має бути позитивною.");
        }
        if ($this->balance - $amount < self::MIN_BALANCE) {
            throw new Exception("Недостатньо коштів. Поточний баланс: " . number_format($this->balance, 2) . " {$this->currency}");
        }
        $this->balance -= $amount;
        echo "Знято: **" . number_format($amount, 2) . " {$this->currency}**<br>";
    }

    /**
     * Отримання поточного балансу.
     * @return float Поточний баланс
     */
    public function getBalance(): float
    {
        return $this->balance;
    }
    
    /**
     * Виведення поточного статусу рахунку.
     */
    public function getStatus(): void
    {
        echo "Поточний баланс: **" . number_format($this->balance, 2) . " {$this->currency}**<br>";
    }
}

// --- Крок 3: Спадкування та статичні властивості ---

/**
 * Накопичувальний рахунок, успадкований від BankAccount.
 */
class SavingsAccount extends BankAccount
{
    // Статична властивість: спільна для всіх об'єктів класу
    public static float $interestRate = 0.05; // 5%

    /**
     * Застосовує відсотки до балансу.
     */
    public function applyInterest(): void
    {
        $interest = $this->balance * self::$interestRate;
        $this->balance += $interest;
        echo "Застосовано відсотки: **" . number_format($interest, 2) . " {$this->currency}** (Ставка: " . (self::$interestRate * 100) . "%)<br>";
    }

    // Можемо також перевизначити метод getStatus, якщо потрібно додати унікальну інформацію
    public function getStatus(): void
    {
        parent::getStatus();
        echo "Тип рахунку: Накопичувальний. Ставка: " . (self::$interestRate * 100) . "%<br>";
    }

    /**
     * Статичний метод для зміни відсоткової ставки
     * @param float $newRate Нова ставка (наприклад, 0.07)
     */
    public static function setInterestRate(float $newRate): void
    {
        if ($newRate >= 0) {
            self::$interestRate = $newRate;
            echo "Статична ставка успішно оновлена до **" . ($newRate * 100) . "%**<br>";
        }
    }
}

// --- Крок 4: Тестування та обробка винятків (Клієнтський код) ---

echo "<h1>Лабораторна робота №5: Банківські рахунки (ООП та Винятки)</h1>";
echo "<hr>";

// 1. Тестування базового рахунку
echo "<h2>1. Тестування BankAccount</h2>";
$account1 = new BankAccount(1000.00, "USD");
$account1->getStatus();

try {
    echo "--- Операція 1: Поповнення на \$500 ---<br>";
    $account1->deposit(500.00);
    $account1->getStatus();
    
    echo "--- Операція 2: Зняття \$1200 ---<br>";
    $account1->withdraw(1200.00);
    $account1->getStatus();
    
    echo "--- Операція 3: Спроба зняття негативної суми ---<br>";
    $account1->withdraw(-100.00);
    
} catch (Exception $e) {
    echo "<p style='color: red;'>**ПОМИЛКА:** " . $e->getMessage() . "</p>";
}

// 2. Тестування винятку недостатньо коштів
echo "--- Операція 4: Спроба зняття залишку ---<br>";
try {
    $account1->withdraw(500.00);
    $account1->getStatus(); // Поточний баланс $300
    
    echo "--- Операція 5: Спроба зняття більшої суми (\$400) ---<br>";
    $account1->withdraw(400.00); // Це викине виняток
    
} catch (Exception $e) {
    echo "<p style='color: red;'>**ПОМИЛКА:** " . $e->getMessage() . "</p>";
    $account1->getStatus(); // Баланс залишається незмінним, $300
}

echo "<hr>";

// 3. Тестування накопичувального рахунку та статичних властивостей
echo "<h2>2. Тестування SavingsAccount</h2>";
$savings1 = new SavingsAccount(5000.00); // UAH за замовчуванням
$savings1->getStatus();

// Використання статичного методу
SavingsAccount::setInterestRate(0.07); // Змінюємо ставку на 7%

try {
    echo "--- Операція 6: Застосування відсотків ---<br>";
    $savings1->applyInterest();
    $savings1->getStatus();
    
    echo "--- Операція 7: Поповнення на 1000 грн ---<br>";
    $savings1->deposit(1000.00);
    $savings1->getStatus();

    echo "--- Операція 8: Зняття 200 грн ---<br>";
    $savings1->withdraw(200.00);
    $savings1->getStatus();

} catch (Exception $e) {
    echo "<p style='color: red;'>**ПОМИЛКА:** " . $e->getMessage() . "</p>";
}

echo "<hr>";

// Демонстрація статичної властивості (інша валюта)
echo "<h2>3. Демонстрація статичної властивості</h2>";
$savings2 = new SavingsAccount(100.00, "EUR");
$savings2->getStatus(); // Зверніть увагу, ставка 7% використовується і тут!

// Змінюємо статичну властивість через об'єкт (хоча краще через клас)
$savings2::$interestRate = 0.10; // Змінюємо ставку на 10%
echo "Ставка змінена через об'єкт **savings2**.<br>";

$savings1->getStatus(); // Перевіряємо, що ставка змінилася і для першого об'єкта
$savings2->getStatus();

?>
