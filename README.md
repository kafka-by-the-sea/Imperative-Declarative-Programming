# Imperative-Declarative-Programming

### Imperative Programming
- 利用迴圈 foreach() 與判斷式 if 的方式寫程式，這也是過去我們習慣的 PHP 風格。
- 程式可讀性較差，特別是接手其他人程式碼，立馬要跟一堆變數、迴圈與判斷式纏鬥，而不能一眼就看出程式所有表達的意思。
```php
//先介紹Imperative Programming的寫法(如下模樣的程式碼)
//特色：以for、if、array來做各種邏輯判斷，實作的細節
//可讀性比較低，無法一眼看出想表達什麼，要一層一層去拆解邏輯
function getUserEmails($users)
{
    $emails = [];
    for ($i = 0; $i < count($users); $i++) {
        $user = $users[$i];
        if ($user->email !== null) {
            $emails[] = $user->email;
        }
    }
    return $emails;
}
```

### Declarative Programming
- 程式可讀性高，可是比較不好除錯，建議是配合 dd() 來使用，這種方式就不需要增加暫存變數，只要在要 debug 的 method 之後加上 ->dd() 即可，非常方便。

```php
//另一種寫法叫做Declarative Programming(如下模樣的程式碼)
//Higher Order Functions，特色：可讀性比較高、可維護性也高，主要是把一些共同之處抽象化，不同的地方把它用closure封裝起來，
//變成是一種Fluent Style的寫法(大量使用Collection這個類別的function)

function getUserEmails($users)
{
    return $users
        ->filter(function($user) {
            return $user->email !== null && $user->name !== null;
        })
        ->map(function($user) {
            return $user->email; 
        });
}
```

## Map, Filter, Reduce 的寫法差異

### Map的寫法

```php
// implement that without any higher order functions like this
// 常見的PHP imperative的寫法
$customerEmails = [];
foreach ($customers as $customer) {
    $customerEmails[] = $customer->email;
}
return $customerEmails;

foreach ($inventoryItems as $item) {
    $stockTotals[] = [
        'product' => $item->productName,
        'total_value' => $item->quantity * $item->price,
    ];
}
return $stockTotals;
```
```php
// 你可以實作成higher order function called map
function map($items, $func)
{
    $results = [];
    foreach ($items as $item) {
        $results[] = $func($item);
    }
    return $results;
}

$customerEmails = map($customers, function ($customer) {
    return $customer->email;
});

$stockTotals = map($inventoryItems, function ($item) {
    return [
        'product' => $item->productName,
        'total_value' => $item->quantity * $item->price,
    ];
});
```

### Filter的寫法
```php
// implement that without any higher order functions like this
// 常見的PHP imperative的寫法
$outOfStockProducts = [];
foreach ($products as $product) {
    if ($product->isOutOfStock()) {
        $outOfStockProducts[] = $product;
    }
}
return $outOfStockProducts;

$expensiveProducts = [];
foreach ($products as $product) {
    if ($product->price > 100) {
        $expensiveProducts[] = $product;
    }
}
return $expensiveProducts;
```
```php
// 你可以實作成higher order function called filter
function filter($items, $func)
{
    $result = [];
    foreach ($items as $item) {
        if ($func($item)) {
            $result[] = $item;
        }
    }
    return $result;
}

$outOfStockProducts = filter($products, function ($product) {
    return $product->isOutOfStock();
});

$expensiveProducts = filter($products, function ($product) {
    return $product->price > 100;
});
```

### Reduce的寫法
```php
// implement that without any higher order functions like this
// 常見的PHP imperative的寫法
$totalPrice = 0;
foreach ($cart->items as $item) {
    $totalPrice = $totalPrice + $item->price;
}
return $totalPrice;

$bcc = '';
foreach ($customers as $customer) {
    $bcc = $bcc . $customer->email . ', ';
}
return $bcc;
```
```php
// 你可以實作成higher order function called reduce
function reduce($items, $callback, $initial)
{
    $accumulator = $initial;
    foreach ($items as $item) {
        $accumulator = $callback($accumulator, $item);
    }
    return $accumulator;
}

$totalPrice = reduce($cart->items, function ($totalPrice, $item) {
    return $totalPrice + $item->price;
}, 0);

$bcc = reduce($customers, function ($bcc, $customer) {
    return $bcc . $customer->email . ', ';
}, '');
```