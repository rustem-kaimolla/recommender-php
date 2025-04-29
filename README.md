# Recommender-PHP

🚀 A lightweight library for building recommender systems in PHP.

[![Tests](https://github.com/rustem-kaimolla/recommender-php/actions/workflows/ci.yml/badge.svg)](https://github.com/rustem-kaimolla/recommender-php/actions)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%5E8.0-8892BF.svg)](https://www.php.net/)
[![Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen.svg)](https://github.com/rustem-kaimolla/recommender-php)


> Supports Item-Item Collaborative Filtering via Jaccard Similarity and an extensible architecture to work with different types of storage.

---

## 📦 Installation

```bash
composer require rustem-kaimolla/recommender-php
```

*(for local development)*

```bash
git clone https://github.com/rustem-kaimolla/recommender-php.git
cd recommender-php
composer install
```

---

## ✨ Основные возможности

- **Item-Item Collaborative Filtering**
- **Jaccard Similarity** (similarity metric)
- **InMemory storage** for fast tests (extensible for Redis, PostgreSQL and others)
- **Clean architecture with interfaces** (PSR-4)
- **Test coverage (PHPUnit)**
- **License MIT**

---

## ⚡ Quick start

```php
<?php

require 'vendor/autoload.php';

use Recommender\Recommender;
use Recommender\Storage\InMemoryStorage;
use Recommender\Similarity\JaccardSimilarity;

$storage = new InMemoryStorage();
$similarity = new JaccardSimilarity();
$recommender = new Recommender($storage, $similarity);

$recommender->addInteraction(1, 10);
$recommender->addInteraction(1, 12);
$recommender->addInteraction(2, 10);
$recommender->addInteraction(2, 11);
$recommender->addInteraction(3, 11);

$recommendations = $recommender->recommendForUser(1, 3);

print_r($recommendations);
```

---

## 📊 Response example

```php
Array
(
    [0] => Array
        (
            [item_id] => 11
            [score] => 0.5
        )
)
```

User 1 is recommended product 11 because it was purchased by other users who purchased similar products.

---

## 🧪 Running tests

```bash
composer test
```

---

## 💚 Development plan

- [x] InMemory storage
- [ ] Redis Storage
- [ ] Popularity-based baseline
- [ ] Event weighting assessment (view, like, purchase)
- [ ] Similarity Matrix Cache
- [ ] Quality metrics (precision@k, recall@k)

---

## 📄 License

The project is licensed under [MIT License](LICENSE).

---

## 🤝 Contribution

If you want to make a pull request or share an idea, you are always welcome! 🚀