<?php

/**
 * Solution for: http://codingdojo.org/kata/Potter/
 */

namespace Dojo\PotterBasket;

class Basket {

    const BOOK_PRICE = 8;
    const AVAILABLE_VERSIONS = [1, 2, 3, 4, 5];
    const DISCOUNT_RULE = [2 => 0.05, 3 => 0.1, 4 => 0.20, 5 => 0.25];

    private $basket = [];

    /**
     * Add books to current basket.
     *
     * @param int $version
     *   Version of book.
     * @param int $quantity
     *   Quantity of books in the specified version.
     *
     * @throws \InvalidArgumentException
     */
    public function addBooks(int $version, int $quantity) {
        if (!in_array($version, self::AVAILABLE_VERSIONS)) {
            throw new \InvalidArgumentException("Invalid book version.");
        }

        $this->basket[$version] = $this->basket[$version] ?? 0;
        $this->basket[$version] += $quantity;
    }

    /**
     * Clear current basket.
     */
    public function clear() {
        $this->basket = [];
    }

    /**
     * Calculate price with discounts based on current basket.
     *
     * @return float
     *   Best price with discounts.
     */
    public function calculatePrice(): float {
        if (empty($this->basket)) {
            return 0;
        }

        $collections = $this->createCollections();
        $total = $this->calculateTotal($collections);

        if (count($collections) == 1) {
            return $total;
        }

        $redistributed_collections = $this->redistributeCollections($collections);
        $redistributed_total = $this->calculateTotal($redistributed_collections);

        return $redistributed_total < $total ? $redistributed_total : $total;
    }

    /**
     * Calculate price with discounts of received collection.
     *
     * @param array $collections
     *   Receive a list of collections created by createCollections().
     *
     * @return float
     *   Calculated price.
     */
    private function calculateTotal(array $collections): float {
        $total = 0;
        foreach ($collections as $collection) {
            $quantity = array_sum($collection);
            $discount = self::DISCOUNT_RULE[$quantity] ?? 0;
            $total += ($quantity * self::BOOK_PRICE) * (1 - $discount);
        }

        return $total;
    }

    /**
     * Based of books on basked, it creates an array of collections.
     *
     * @return array
     *   A list of collections.
     */
    private function createCollections(): array {
        $basket = $this->basket;

        $collections = [];
        for ($i = 0; $i < max($this->basket); $i++) {
            $basket = array_filter($basket);
            foreach ($basket as $version => &$quantity) {
                $collections[$i][$version] = 1;
                $quantity--;
            }
        }

        return $collections;
    }

    /**
     * Receives an array of collections and redistribute trying to find a
     * better discount.
     *
     * @param array $collections
     *   Collection already organized by bigger to smaller collections.
     *
     * @return array
     *   Redistributed array of collections.
     */
    private function redistributeCollections(array $collections): array {
        foreach (array_keys($collections) as $i) {
            foreach (array_reverse(array_keys($collections)) as $j) {
                // Don't need to continue if reached the middle of collection.
                if ($i == $j || count($collections[$i]) <= count($collections[$j])) {
                    break;
                }

                foreach ($collections[$i] as $version => $quantity) {
                    // Check if version exist on smaller collections, if not, remove version
                    // from bigger collection and insert into smaller collection.
                    if (!isset($collections[$j][$version])) {
                        $collections[$j][$version] = 1;
                        unset($collections[$i][$version]);
                    }

                    // Don't need to continue if bigger collection has the same size or is smaller.
                    if (count($collections[$i]) <= count($collections[$j])) {
                        break;
                    }
                }
            }
        }

        return $collections;
    }

}
