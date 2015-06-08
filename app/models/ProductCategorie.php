<?php

class ProductCategorie extends Eloquent
{
    protected $table = "products_categories";
    public $timestamps = false;

    public static function add($category, $prod_id){
        foreach($category as $cat_id){
            $prod_cat = DB::table('products_categories')->insert(array('product_id' => $prod_id, 'category_id' => $cat_id)) ;
        }
    }


    public static function delete_prod_cats($prod_id){
        $prod_cate_delete = DB::table("products_categories")->where(array('product_id' => $prod_id))->delete();
        return $prod_cate_delete;
    }


    public function products(){
        return $this->hasMany('ProductCategorie');
    }
}