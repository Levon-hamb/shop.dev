<?php

class Product extends Eloquent
{
    protected $table = 'products';

    public $timestamps = false;

    public static function add($date, $photoPhat){
        $product = Product::insertGetId(
            array('user_id' => Auth::user()->id,
                'product_name' => $date['name'],
                'product_description' => $date['description'],
                'product_price' =>	$date['price'],
                'price_currency' => $date['currency'],
                'photo_path' => $photoPhat,
                'qty' => $date['qty']
            ));
        return $product;

    }

    public static function delete_product($id){
        $product = Product::where(array('id' => $id))->delete();
        return $product;
    }

    public  function categories() {
        return $this->hasMany('ProductCategorie');
    }

    public static function edit_save($date, $photoPhat ){
        if($photoPhat != null) {
            $product = Product::where(array('id' => $date['prod_id'], 'user_id' => Auth::user()->id))
                ->update(array('user_id' => Auth::user()->id,
                    'product_name' => $date['name'],
                    'product_description' => $date['description'],
                    'product_price' => $date['price'],
                    'price_currency' => $date['currency'],
                    'qty' => $date['qty'],
                    'photo_path' => $photoPhat
                ));
        }else{
            $product = Product::where(array('id' => $date['prod_id'], 'user_id' => Auth::user()->id))
                ->update(array('user_id' => Auth::user()->id,
                    'product_name' => $date['name'],
                    'product_description' => $date['description'],
                    'qty' => $date['qty'],
                    'product_price' => $date['price'],
                    'price_currency' => $date['currency']
                ));
        }
        return $product;
    }

    public static function getSearchesProducts($srch, $product_ids){
        $products = Product::select();
        if($srch){
            $products = $products->where('product_name', 'LIKE', '%'.$srch.'%');
        }
        if($product_ids){
            $products = $products->whereIn('id', $product_ids);
        }
        $products = $products->distinct()->get()->toArray();
        return $products;
    }

    public static function soldQty($products){
        foreach($products as $product){
            $prod = Product::where('id', $product->product_id)->get()->toArray();
            $sold_qty = $prod[0]["sold_qty"];
            $total = $sold_qty + $product->qty;
            $sold = Product::where('id', $product->product_id)->update(array('sold_qty' => $total));
        }
        return true;
    }
}

?>