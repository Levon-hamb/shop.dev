<?php

class Order extends Eloquent{

    protected $table = 'orders';

    public static function add($transaction_id){

        $data_time = new \DateTime;
        $order_id = Order::insertGetId(
            array('transaction_id' => $transaction_id,
                'state' => 'null',
                'user_id' => Auth::id(),
                'created_at' => $data_time,
                'updated_at' => $data_time
            ));
        return $order_id;

    }

    public static function state_update($payment_id, $state){
        $state = Order::where('transaction_id', '=', $payment_id)->update(array('state' => $state));
        return $state;
    }

    public static function getId($payment_id){
        $order = Order::select('id')->where(array('transaction_id' => $payment_id))->first();
        return $order;
    }

    public function items(){
        return $this->hasMany('OrderItem');

    }

    public static function getPurchasedItems(){
        $orders = DB::table('orders as o')
            ->join('order_items AS oi ', 'o.id', '=', 'oi.order_id')
            ->join('products AS p', 'oi.product_id', '=', 'p.id')
            ->where('o.user_id', '=', Auth::id())
            ->where('state', 'approved')
            ->select('oi.qty', 'p.product_name', 'p.photo_path', 'p.product_description', 'p.product_price', 'p.price_currency', 'o.created_at')
            ->get();
        return $orders;
    }

    public static function getSoldItems(){
        $orders = DB::table('products as p')
            ->join('order_items AS oi ', 'p.id', '=', 'oi.product_id')
            ->join('orders AS o', 'oi.order_id', '=', 'o.id')
            ->where('p.user_id', Auth::id())
            ->where('o.state', 'approved')
            ->select('oi.qty', 'p.product_name', 'p.photo_path', 'p.product_description', 'p.product_price',
                'p.price_currency', 'o.created_at')
            ->get();
        return $orders;
    }

    public static function getAllSoldItems(){

    }

    public static function getAllPurchasedItems(){

    }


}