<?php

class OrderItem extends Eloquent
{
    protected $table = 'order_items';

    public static function add($products, $qty, $order_id){

        foreach($products as $key=>$product) {

            $item = OrderItem::insert(
                array('product_id' => $product['id'],
                    'qty' => $qty[$product['id']],
                    'price' => $product['product_price'],
                    'currency' => $product['price_currency'],
                    'order_id' => $order_id
                ));
        }
    }

}