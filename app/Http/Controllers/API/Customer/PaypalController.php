<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use App\Models\Plans;
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
use Auth;
class PaypalController extends Controller
{
    private $_api_context;
    
    public function __construct()
    {
            
        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    public function subscription(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'plan_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['status'=>false,'message' => "Please enter valid plan id."],400);       
        }

        $plan_id = $request->plan_id;        
        // Get plan/subscription info
        $plan = Plans::find($plan_id);
        if($plan){
            $name = $plan->name;
            $price = $plan->price;
            $quota = $plan->bookings;

            $user_id = auth::user()->id;       

            // Paypal Logic
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $item_1 = new Item();

            $item_1->setName($name)
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($price);

            $item_list = new ItemList();
            $item_list->setItems(array($item_1));

            $amount = new Amount();
            $amount->setCurrency('USD')
                ->setTotal($price);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Purchase washngo booking subscription');

            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(URL::route('status')."?id=$user_id&quota=$quota")
                ->setCancelUrl(URL::route('status'));

            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));            
            try {
                $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PPConnectionException $ex) {
                if (\Config::get('app.debug')) {   
                    return response()->json(['status'=>false,'message' => 'Connection timeout.'],400);
                } else {
                    return response()->json(['status'=>false,'message' => 'Some error occur, sorry for inconvenient.'],400);
                }
            }

            foreach($payment->getLinks() as $link) {
                if($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }
            
            Session::put('paypal_payment_id', $payment->getId());        
            if(isset($redirect_url)) {               
                return response()->json(['status'=>true,'message' => 'Redirect to payment page.','redirect_url'=>$redirect_url],200);
            }

        }else{
            return response()->json(['status'=>false,'message' => "Plan does not exists"],400);       
        }
        
        return response()->json(['status'=>false,'message' => $exception->getMessage()],400);
    }

    
}
