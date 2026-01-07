# Result for PHP

A zero-dependency, production-ready PHP implementation of Rust's `Result` type. It brings elegant error handling and functional programming patterns to PHP 7.1+, eliminating the need for nested try-catch blocks and implicit exceptions.

## 🌟 Features

* **Rust-compliant API**: Method names and logic are 1:1 aligned with `std::result::Result`.
* **No `new` Keyword**: Functional constructors `Ok()` and `Err()` for a cleaner syntax.
* **Type Safe**: Encourages explicit error handling.
* **Chainable**: Supports monadic operations like `map`, `and_then`, and `or_else`.
* **PSR-12 Compliant**: Fully follows PHP coding standards.

---

## 🚀 Installation

Install the package via [Composer](https://getcomposer.org/):

```bash
composer require aphonix/result

```

---

## 🛠 Usage

### Basic Example

Instead of throwing exceptions that break the control flow, return a `Result`:

```php
use function Ok;
use function Err;

function divide(float $numerator, float $denominator): \Aphonix\Result\Result {
    if ($denominator === 0.0) {
        return Err("Division by zero");
    }
    return Ok($numerator / $denominator);
}

$result = divide(10, 2);

if ($result->is_ok()) {
    echo "Success: " . $result->unwrap(); // 5
} else {
    echo "Error: " . $result->unwrap_err();
}

```

### Chaining Operations (The Rust Way)

Chain multiple fallible operations gracefully using `and_then` (monadic bind):

```php
$final_value = fetch_user_data($id)           // Returns Result
    ->and_then('validate_user')               // Returns Result
    ->map(function($user) {                   // Transform value
        return $user->getName();
    })
    ->unwrap_or("Guest");                     // Default value if any step failed

```

---

## 📖 API Reference

### Variant Checks

* `is_ok()`: Returns `true` if the result is `Ok`.
* `is_err()`: Returns `true` if the result is `Err`.

### Value Extraction

* `unwrap()`: Returns the value or throws a `RuntimeException` (Panic).
* `unwrap_err()`: Returns the error or throws a `RuntimeException`.
* `expect(string $msg)`: Returns the value or throws with a custom message.
* `unwrap_or($default)`: Returns the value or the provided default.
* `unwrap_or_else(callable $op)`: Returns the value or computes a default from a closure.

### Transformation & Chaining

* `map(callable $op)`: Transforms the `Ok` value.
* `map_err(callable $op)`: Transforms the `Err` value.
* `and_then(callable $op)`: Chains another operation that returns a `Result`.
* `or_else(callable $op)`: Recovers from an error by returning a new `Result`.

---

## 🧪 Testing

The library is fully covered with unit tests. You can run them using PHPUnit:

```bash
./vendor/bin/phpunit tests

```

---

## 📜 License

The MIT License (MIT). Please see [License File](https://www.google.com/search?q=LICENSE) for more information.

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.