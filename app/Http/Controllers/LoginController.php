<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests;
use App\Models\User;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest', ['except' => 'logout']);
    // }

    private $_api_context;
    
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']); 
        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    public function login()
    {
        return view('login');
    }

    /**
     * Show the application loginprocess.
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->guard('web')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {
            $user = auth()->guard('web')->user();
            return redirect()->route('dashboard');
            
        } else {
            return back()->with('error','Invalid credentials.');
        }

    }

    /**
     * Show the application logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->guard('web')->logout();
        \Session::flush();
        return redirect(route('login'));
    }

    public function pay()
    {
        return view('paypal');
    }

    public function status(Request $request)
    {
        // dd($request->all());
        // $payment_id = Session::get('paypal_payment_id');
        $payment_id =  $request->paymentId;
        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {            
            return redirect('pay')->with('error', 'Payment failed. Please go back to your app for further booking.');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));        
        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') {   
            
            // Update user booking quote based upon subscription plan
            $user_id = $request->id;
            $quota = $request->quota;

            $user = User::find($user_id);
            if($user){
                $user->booking_quota += $quota;
                $user->save();
                return redirect('pay')->with('success', 'Payment success. Please go back to your app for further booking.');
            }
            return redirect('pay')->with('error', 'Payment failed. User does not exists. Please try again via app.');
        }
		return redirect('pay')->with('error', 'Payment failed. Please go back to your app for further booking.');
    }
}
