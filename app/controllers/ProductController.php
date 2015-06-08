<?php

require_once  app_path() . "/config/constants.php";
class ProductController extends BaseController
{

    public function edit_save(){

        $date = Input::all();
        $rules = array(
            'name' => 'required|min:2',
            'description' => 'required|min:2',
            'qty' => 'required|regex:/^(([1-9]{1})+([0-9]{0,18})$)/i',
            'price' => 'required|min:1|regex:/^([0-9]{1,18}$)/i',
            'currency' => 'required|regex:/^([A-Z]{3,4})$/i',
            'photo' => 'max:1000000000000000000'
        );

        $validator = Validator::make($date, $rules);

        if($validator->fails())
        {
            $messages = $validator->messages()->all();
            $categories = Categorie::all();
            return View::make('product/edit')->with('errors', $messages)->with('date', $date)->with('currency', unserialize(_CURRENCY_))->with('categories', $categories);
        }
        else{
            $photoPhat = null;
            if(Input::file('photo')) {
                if (Input::file('photo')->isValid()) {

                    $destinationPath = public_path() . '/resources/images'; // upload path
                    $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
                    $fileName = rand(111, 99999) . '.' . $extension; // renaming image
                    Input::file('photo')->move($destinationPath, $fileName); // uploading file to given path
                    $photoPhat = SITE_URL . '/resources/images/' . $fileName;
                }
            }elseif(Input::get("photo")){

                $photoPhat = Input::get("photo");
            }

            $prod = Product::edit_save($date, $photoPhat);
            $prod_cate_delete = ProductCategorie::delete_prod_cats($date['prod_id']);

            if($date['category']){
                if(Request::ajax()){
                    $date['category'] = json_decode($date['category'], true);
                }
                $prod_cate = ProductCategorie::add($date['category'], $date['prod_id']);
            }

            if (Request::ajax()) {
                    echo '1';
            }else {
                return Redirect::to('/myproducts');
            }

        }
    }

    public function edit($id){

        $product = Product::find($id);

        if($product->user_id == Auth::user()->id || Auth::user()->is_admin){
            $prod = new Product();
            $prod_categories = $prod->find($id)->categories;
            $categories = Categorie::all();
            $prod_categories_id = array();
            foreach ($prod_categories as $prod_category) {
                $prod_categories_id[] = $prod_category->category_id;
            }

            return View::make('product/edit')->with('prod_categories_id', $prod_categories_id)
                ->with('product', $product)->with('currency', unserialize(_CURRENCY_))->with('categories', $categories)->with('id', $id);
        }else{
            // this is not user product
            return Response::view('notfound', array(), 404);
        }


    }

    public function delete($id){

        $product = Product::find($id);
        if($product->user_id == Auth::user()->id || Auth::user()->is_admin){
            $prod_photo_phat = $product->photo_path;
            $exp  = explode(SITE_URL, $prod_photo_phat);
            $product_id = $product->id;
            $product = Product::delete_product($id);
            if($product){
                if(Session::has('cart')){
                    $cart = Session::get('cart');
                    foreach($cart as $key => $val){
                        if($cart[$key]['id'] == $product_id){
                            unset($cart[$key]);
                            Session::forget('cart');
                            Session::put('cart', $cart);
                        }
                    }
                }
                unlink(public_path($exp[1]));
                return Redirect::to('/myproducts');
            }
        }else{
            return Response::view('notfound', array(), 404);
        }
    }

    public function add_view(){

        $categories = Categorie::all();

        return View::make('product/add')->with('currency', unserialize(_CURRENCY_))->with('categories', $categories);
    }

    public function add(){

        $date= Input::all();

        $rules = array(
            'name' => 'required|min:2',
            'description' => 'required|min:2',
            'price' => 'required|min:1|regex:/^([0-9]{1,18}$)/i',
            'currency' => 'required|regex:/^([A-Z]{3})$/i',
            'photo' => 'required|max:1000000000000000000',
            'qty' => 'required|regex:/^(([1-9]{1})+([0-9]{0,18})$)/i'
        );

        $validator = Validator::make($date, $rules);

        if($validator->fails())
        {
            $messages = $validator->messages()->all();

            $categories = Categorie::all();
            return View::make('product/add')->with('errors', $messages)->with('old_data', $date)->with('currency', unserialize(_CURRENCY_))->with('categories', $categories);
        }
        else{
            if(Input::file('photo')->isValid()) {
                $destinationPath = public_path().'/resources/images'; // upload path
                $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
                $fileName = rand(111,99999).'.'.$extension; // renaming image
                Input::file('photo')->move($destinationPath, $fileName); // uploading file to given path
                $photoPhat = SITE_URL.'/resources/images/'.$fileName;
            }

            $prod = Product::add($date, $photoPhat);

            if(Request::ajax()) {
                $date['category'] = json_decode($date['category'], true);
            }
            if(isset($date['category'])) {
//                var_dump($date['category']);
//                dd($prod);

                $prod_cat = ProductCategorie::add($date['category'], $prod);

//                $pro = new ProductCategorie();
//                $pro->product_id = '25';
//                $pro->category_id = '3';
//                $pro->save();
////                dd("asdasdad");
            }

            if (Request::ajax()) {
                if($prod) {
                    echo '1';
                }else{
                   echo '0';
                }
            }else {
                return Redirect::to('/myproducts');
            }
        }

    }

    public function getProduct($id){

        if(!Auth::check()){
            return View::make('user/no_access');
        }else {
            $product = Product::find($id);
            if (isset($product->user_id)) {
                $user = User::find($product->user_id);

                return View::make('product/product')->with('product', $product)->with('user', $user);
            }else{
                return Response::view('notfound', array(), 404);
            }
        }

    }

    public function search(){

        $date = Input::all();

        if($date['srch'] || isset($date['category'])){
            if($date['srch'] || isset($date['category'])){
                if($date['category'] == 0){
                    $products = Product::getSearchesProducts($date['srch'], 0);

                    if(count($products) == 0){
                        $message = 'there is no such product';
                        return Redirect::to('/')->with('message', $message);
                    }

                    return View::make('index')->with(array('products' => $products, 'category' => $date['category'], 'keyword' => $date['srch']));

                }else{
                    $pro = new Categorie();
                    $product_ids = $pro->find($date['category'])->products->lists('product_id');
                    $products = Product::getSearchesProducts($date['srch'], $product_ids);
                    $products = Product::getSearchesProducts($date['srch'], $product_ids);

                    return View::make('index')->with(array('products' => $products, 'category' => $date['category'], 'keyword' => $date['srch']));
                }
            }else{
                $message = 'there is no such product';
                return Redirect::to('/')->with('message', $message);
            }
        }


    }

}