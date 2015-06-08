<?php

class Categorie extends Eloquent{

    protected $table = 'categories';

    public $timestamps = false;

    public static function add($category){
        $cat = Categorie::insert(array('category_name' => $category));
        return $cat;

    }

    public function products(){
        return $this->hasMany('ProductCategorie','category_id');
    }
}