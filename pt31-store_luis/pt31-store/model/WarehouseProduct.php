<?php

namespace proven\store\model;

class Warehouseproduct {
    
    // private ?int $warehouse_id;
    // private ?int $product_id;
    // private ?int $stock;

    public function __construct(
            private ?int $warehouse_id = 0,
            private ?int $product_id=null,
            private ?int $stock=null
    ) {
        $this->warehouse_id=$warehouse_id;
        $this->product_id=$product_id;
        $this->stock=$stock;
    }

    public function getWarehouse_id(): ?int {
        return $this->warehouse_id;
    }

    public function getProduct_id(): ?int {
        return $this->product_id;
    }

    public function getStock(): ?int {
        return $this->stock;
    }

    public function setWarehouse_id(?int $warehouse_id): void {
        $this->warehouse_id = $warehouse_id;
    }

    public function setProduct_id(?int $product_id): void {
        $this->product_id = $product_id;
    }

    public function setStock(?int $stock): void {
        $this->stock = $stock;
    }

    public function __toString() {
        return sprintf("Warehouse{[warehouse_id=%d][product_id=%s][stock=%s]}",
                $this->warehouse_id, $this->product_id, $this->stock);
    }

}
