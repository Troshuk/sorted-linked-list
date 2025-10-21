# 🧩 SortedLinkedList

A **sorted singly linked list** in PHP that holds either `int` or `string` values. The list maintains elements in **ascending order** at all times. Duplicate values are ignored.

---

## ✅ Advantages

- **Sorted by design** – insertions always maintain order.
- **Consistent iteration** – traversing the list naturally returns elements in sorted order.
- **Predictable structure** – avoids PHP array quirks like numeric reindexing.
- **Lightweight abstraction** – minimal overhead, no internal array re-sorting.

---

## ⚖️ Trade-offs

- **Sequential access (`O(n)`)** – accessing specific positions requires walking the list.
- **Manual node management** – operations like insert/remove involve traversal logic.

---

## 🧪 Development Tools

This library is configured with:

- **PHPStan** – static analysis
- **PHPUnit** – automated testing
- **PHPCS / PHP CS Fixer** – coding standards

---

## ⚙️ Installation

Clone the repository and install dependencies:

```bash
git clone https://github.com/Troshuk/sorted-linked-list.git
cd sorted-linked-list
composer install
```

---

### 💡 Example Usage

Refer to the `examples` directory for usage samples.

---

### 🛠️ Running Checks

```# Run tests
composer test

# Run PHPCS
composer cs

# Auto-fix coding standards
composer fix

# Run PHPStan static analysis
composer stan```
