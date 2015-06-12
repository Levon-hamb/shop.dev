<?php

class AdminController extends BaseController
{

    public function index(){

        $products = Product::all();
        return View::make('index')->with('products', $products);
    }

    public function allProducts(){

        $products = Product::all();
        return View::make('user/product')->with('products', $products);
    }

    public function categories(){
        $categories = Categorie::all()->toArray();

        return View::make('admin/categories')->with('categories', $categories);
    }

    public function addCat()
    {

        $data = Input::all();
        $rules = array(
            'category' => 'required'
        );
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            return Redirect::to('/admin/categories')->with('errors', $messages);
        } else {
            $category = Categorie::add($data['category']);
            if($category){
                return Redirect::to('/admin/categories');
            }else{
                return Redirect::to('/admin/categories');
            }

        }
    }

    public function editCat($id){
        $cat = Categorie::find($id)->toArray();
        if($cat){
            return View::make('admin/editcategory')->with('cat', $cat);
        }
    }

    public function deleteCat($id){
        $cat = Categorie::where('id',$id)->delete();
        return Redirect::to('/admin/categories');
    }

    public function saveCat(){
        $date = Input::all();

        $rules = array(
            'category_name' => 'required',
            'category_id' => 'required'
        );
        $validator = Validator::make($date, $rules);

        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            return Redirect::to('/admin/editcategory')->with('errors', $messages);
        } else {
            $category = Categorie::where(array('id' => $date['category_id']))->update(array('category_name' => $date['category_name']));
            if($category){
                return Redirect::to('/admin/categories');
            }else{
                return Redirect::to('/admin/categories');
            }

        }
    }

    public function allPurchased(){
        $orders = Order::getAllPurchasedItems();
        if($orders){
            return View::make('product/purchased')->with('products', $orders);
        }
    }

    public function allSold(){
        $orders = Order::getAllSoldItems();
        if($orders){
            return View::make('product/sold')->with('products', $orders);

        }
    }
}