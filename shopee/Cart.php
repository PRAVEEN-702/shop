<?php
require_once 'index.php';
require_once 'product.php';
class Cart {
    private $products;

    public function __construct() {
        $this->products = [];
    }

    public function addProduct(Product $product) {
        $this->products[] = $product;
    }

    public function removeProduct($productId) {
        foreach ($this->products as $key => $product) {
            if ($product->getId() === $productId) {
                unset($this->products[$key]);
                break;
            }
        }
    }

    public function getProducts() {
        return $this->products;
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }
        return $total;
    }
}
