<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
class PaypalController extends BaseController
{
    private $_api_context;
    public function __construct()
    {

// setup PayPal api context
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }


    public function postPayment()
    {

        $ids = Input::get('id');
        $qty = Input::get('quantity');

        $valid = $this->validationIdQty($ids,$qty);
        if($valid){
            return Response::view('notfound', array(), 404);
        }


        $products = Product::whereIn('id', $ids)->get();
        if(!count($products)){
            return Redirect::to('/');
        }else{
            foreach($products as $product){
                $max = $product->qty - $product->sold_qty;
                foreach($qty as $key=>$value){
                    if($key == $product->id ){
                        $qty_new = $value;
                        if($max < $qty_new){
                            $message = "this quantity is not valid for this product please enter low quantity";
                            return Redirect::to('/cart')->with('message', $message);
                        }
                    }
                }
            }
        }
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item = array();
        $total = 0;
        foreach($products as $key=>$product) {

            $item[$key] = new Item();
            $item[$key]->setName($product['product_name'])// item name
            ->setCurrency('USD')
                ->setQuantity($qty[$product['id']])
                ->setPrice($product['product_price']);
            $total += $qty[$product['id']]*$product['product_price'];

        }
        $item_list = new ItemList();
        $item_list->setItems($item);
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($total);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status')) // Specify return URL
        ->setCancelUrl(URL::route('payment.cancel_order'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);

        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {
        // redirect to paypal
            return Redirect::away($redirect_url);
        }
        return Redirect::route('original.route')
            ->with('error', 'Unknown error occurred');
    }

    public function getPaymentStatus()
    {

        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');
        // clear the session payment ID
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            return Redirect::route('original.route')
                ->with('error', 'Payment failed');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
// PaymentExecution object includes information necessary
// to execute a PayPal account payment.
// The payer_id is added to the request query parameters
// when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
//Execute the payment
        $result = $payment->execute($execution, $this->_api_context);


        echo '<pre>';
        var_dump($result->transactions);
        var_dump(Session::get('cart'));
        exit;
//        dd('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');

        echo '<pre>';print_r($result);echo '</pre>';exit;
         // DEBUG RESULT, remove it later
        if ($result->getState() == 'approved') { // payment made
            return Redirect::route('original.route')
                ->with('success', 'Payment success');
        }
        return Redirect::route('original.route')
            ->with('error', 'Payment failed');
    }

    public function getSuccessPayment()
    {
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername('paypal account');
        $gateway->setPassword('paypal password');
        $gateway->setSignature('AiPC9BjkCyDFQXbSkoZcgqH3hpacASJcFfmT46nLMylZ2R-SV95AaVCq');
        $gateway->setTestMode(true);

        $params = Session::get('params');

        $response = $gateway->completePurchase($params)->send();
        $paypalResponse = $response->getData(); // this is the raw response object

        if(isset($paypalResponse['PAYMENTINFO_0_ACK']) && $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success') {

            // Response
            // print_r($paypalResponse);

        } else {

            //Failed transaction

        }

        return View::make('result');
    }

    public function addToCart(){

        $id = Input::get('id');
        $qty = Input::get('quantity');

        $valid = $this->validationIdQty($id,$qty);
        if($valid){
            return Response::view('notfound', array(), 404);
        }
        $products = Product::whereIn('id', $id)->get();
        if(!count($products)){
            return Redirect::to('/');
        }else{
            foreach($products as $product){
                if(Session::has('cart')) {
                    foreach (Session::get('cart') as $prod) {
                        if ($product->id == $prod['id']) {
                            $max = $product->qty - $product->sold_qty;
                            foreach($qty as $key=>$value){
                                if($key == $prod['id'] ){
                                    $qty_new = $value + $prod['qty'];
                                    if($max < $qty_new){
                                        $message = "this quantity is not valid for this product please enter low quantity";
                                        return Redirect::to('/cart')->with('message', $message);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $data = [
            "id" => $id[0],
            "qty" => $qty[$id[0]],
        ];

        if(Session::has('cart')){
            $cart = Session::get('cart');
            foreach($cart as $key=>$val){
                if($data['id'] == $cart[$key]['id']){
                    $cart[$key]['qty'] = $cart[$key]['qty'] + $data['qty'];
                    Session::put('cart', $cart);
                    return Redirect::to('/');
                }
            }
            array_push($cart, $data);
            Session::put('cart', $cart);
            return Redirect::to('/');
        }else{
            $array = array();
            array_push($array, $data);
            Session::put('cart', $array);
            return Redirect::to('/');
        }
    }

    public function cart()
    {
        $cart = Session::get('cart');
        if (count($cart)) {
            $ids = array();
            $qty = array();
            foreach ($cart as $item) {
                $ids[] = $item['id'];
                $qty[$item['id']] = $item['qty'];
            }
            $products = Product::whereIn('id', $ids)->get();
            return View::make('cart')->with(array('products' => $products, 'qty' => $qty));
        }else{
            return View::make('cart');
        }
    }

    public function deleteCartProduct($id){

        if(Session::has('cart')){
            $cart = Session::get('cart');
            foreach($cart as $key=>$val) {
                if ($cart[$key]['id'] == $id) {
                    unset($cart[$key]);
                    Session::forget('cart');
                    Session::put('cart', $cart);
                    return Redirect::to('/cart');
                }
            }
        }
    }

    public function saveCart(){

        $ids = Input::get('id');
        $qty = Input::get('quantity');
        $valid = $this->validationIdQty($ids,$qty);

        if($valid){
            return Response::view('notfound', array(), 404);
        }
        $products = Product::whereIn('id', $ids)->get();

        if(!count($products)){
            return Redirect::to('/');
        }else{
            foreach($products as $product){
                if(Session::has('cart')) {
                    foreach (Session::get('cart') as $prod) {
                        if ($product->id == $prod['id']) {
                            $max = $product->qty - $product->sold_qty;
                            foreach($qty as $key=>$value){
                                if($key == $prod['id'] ){
                                    $qty_new = $value ;
                                    if($max < $qty_new){
                                        $message = "this quantity is not valid for this product please enter low quantity";
                                        return Redirect::to('/cart')->with('message', $message);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $cart = array();
        foreach($ids as $id){
            $cart[] = [
                'id' => $id,
                'qty' => $qty[$id]
            ];
        }
        Session::forget('cart');
        Session::put('cart', $cart);
        return Redirect::to('/cart');
    }

    public function validationIdQty($ids, $qty){
        foreach($ids as  $key=>$id){
            $rules = array(
                $key => 'required|regex:/^[1-9]{1}+([0-9]{0,10}$)/i'
            );
            $validator = Validator::make($ids, $rules);
            if($validator->fails()){
                return true;
            }

        }
        foreach($qty as  $key=>$qt){
            $rules = array(
                $key => 'required|regex:/^[1-9]{1}+([0-9]{0,10}$)/i'
            );
            $validator = Validator::make($qty, $rules);
            if($validator->fails()){
                return true;
            }
        }
        foreach($qty as  $key=>$value){
            $validator = $this->validId($key);
            if(!$validator){
                return true;
            }
        }

        return false;
    }

    public function validId($id){

        $pattern = '/^[1-9]{1}+([0-9]{0,10}$)/i';
        if(preg_match($pattern, $id)){
            return true;
        }else{
            return false;
        }


    }

}