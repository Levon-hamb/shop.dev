<?php
// this is after make the payment, PayPal redirect back to your site
Route::get('payment/status', array(
    'as' => 'payment.status',
    'uses' => 'OrderController@getPaymentStatus',
));
Route::get('payment/cancel_order', array(
    'as' => 'payment.cancel_order',
    'uses' => 'IndexController@index'
));

App::missing(function($exception)
{
    return Response::view('notfound', array(), 404);
});

Route::group(['before'=>'admin', 'prefix'=>'/admin'],function(){
    Route::get('/', 'AdminController@index');
    Route::get('/myproducts', 'AdminController@allProducts');
    Route::get('/categories', 'AdminController@categories');
    Route::post('/addCategory', 'AdminController@addCat');
    Route::get('/editCategory/{id}', 'AdminController@editCat');
    Route::get('/deleteCategory/{id}', 'AdminController@deleteCat');
    Route::get('/soldProducts', 'OrderController@allSold');
    Route::get('/purchasedProducts', 'OrderController@allPurchased');
});

Route::get('/', 'IndexController@index');
Route::get('/product/{id}', 'ProductController@getProduct');
Route::post('uniqueEmail', 'UserController@uniqueEmail');
Route::post('/save_pass', 'UserController@save_pass');
Route::post('saveProfile', 'UserController@saveProfile');
Route::get('/cart', 'OrderController@cart');
Route::post('/addcart', 'OrderController@addToCart');
Route::post('/search', 'ProductController@search');
Route::get('/deletecartprod/{id}', 'OrderController@deleteCartProduct');
Route::post('/savecart', 'OrderController@saveCart');

Route::group(['before'=>'guest'],function(){
    Route::post('signup', 'UserController@signUp');
    Route::post('signin', 'UserController@signIn');
    Route::get('/signup','IndexController@signUp');
    Route::get('/signin', 'IndexController@signIn');
    Route::get('forgotpass', 'IndexController@forgot');
    Route::post('forgot', 'IndexController@forgotPass');
    Route::get('/resetpass/{token}', 'IndexController@reset');
});

Route::group(['before'=>'user'],function(){
    Route::get('/profile', 'UserController@profile');
    Route::get('editProfile', 'UserController@edit_profile');
    Route::get('resetpassword', 'UserController@resetpassword');
    Route::get('/logout', 'UserController@logout');
    Route::get('/myproducts', 'UserController@getProducts');
    Route::get('/add', 'ProductController@add_view');
    Route::post('/add', 'ProductController@add');
    Route::get('/edit/{id}', 'ProductController@edit');
    Route::post('/edit', 'ProductController@edit_save');
    Route::get('/delete/{id}', 'ProductController@delete');
    Route::get('/soldProducts', 'OrderController@soldProducts');
    Route::get('/purchasedProducts', 'OrderController@purchasedProducts');
    // Add this route for checkout or submit form to pass the item into paypal
    Route::post('/payment', array(
        'as' => 'payment',
        'uses' => 'OrderController@postPayment',
    ));
});



