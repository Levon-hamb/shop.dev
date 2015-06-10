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

    public static function getItems(){
        $orders = DB::table('orders')
            ->join('order_items', function($join)
        {
            $join->on('orders.id', '=', 'order_items.order_id')
                ->where('orders.user_id', '=', Auth::id());
        })
//            ->join('orders', 'orders.user_id', '=', Auth::id())
            ->get();
        return $orders;

//        $orders =  Order::where('user_id', Auth::id())->get();
//        return $orders;
    }
}