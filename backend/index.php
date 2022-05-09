<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;
use Flutterwave\Payment\Payment;
use Flutterwave\Customer\Customer;
use Flutterwave\Payload\PaymentPayloadStandard as Payload;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Add Slim routing middleware
$app->addRoutingMiddleware();

// Set the base path to run the app in a subdirectory.
// This path is used in urlFor().
$app->add(new BasePathMiddleware($app));

$app->addErrorMiddleware(true, true, true);

$app->post('/pay', function (Request $request, Response $response) {
    
    $postData = json_decode(file_get_contents('php://input'), true);
    $payload = json_encode($postData);

    $keys = ['PUBLIC_KEY' => 'FLWPUBK_TEST-647f6289f74aba024f10cc12f71bd6a2-X', 'SECRET_KEY' => 'FLWSECK_TEST-1609ba49bee599841c9a590a97984685-X'];

    //create a customer object
    $customer = new Customer(
        $postData['customer_id'],
        $postData['customer_name'],
        $postData['customer_email'],
        $postData['customer_phone']
    );

    //create a payment object
    $payment = new Payment($keys, $postData['amount'], $postData['currency'] , $postData['payment_method'] , $customer);

    //get the transaction reference
    $tx_ref =  $payment->get_tx_ref();

    //prepare payload
    $payload = new Payload($tx_ref, 100, 'NGN', ['card'], $customer, 'https://google.com');
    $payload->add_customization(
        [
            'logo' => 'https://avatars.githubusercontent.com/u/39011309?v=4',
            'description' => 'software readily available',
            'title' => 'Bajoski34'
        ]
    );
    $payload->add_metadata([
        'isRecurring' => 'true'
    ]);

    //get payment link
    $payment_link = $payment->get_payment_url($keys['SECRET_KEY'], $payload);

    $endpoint_response = json_encode([
        'payment_link' => $payment_link
    ]);
    
    $response->getBody()->write($endpoint_response);
    return $response
              ->withHeader('Content-Type', 'application/json');

});


$app->get('/verifyTransaction{tx_ref}', function (Request $request, Response $response, $args) {
    $params = $request->getQueryParams();
    $keys = ['PUBLIC_KEY' => 'FLWPUBK_TEST-647f6289f74aba024f10cc12f71bd6a2-X', 'SECRET_KEY' => 'FLWSECK_TEST-1609ba49bee599841c9a590a97984685-X'];

    $tx_ref = $_GET['tx_ref'];
    //query database for the transaction details using $tx_ref
    $saved_transaction_details = [
        'amount' => 100,
        'currency' => 'NGN',
    ];
    
    $result = Payment::confirm_payment($keys, $tx_ref, $saved_transaction_details);// maybe add a callback function to handle event on confirm

    switch ($result) {
        case Payment::SUCCESS_STATUS:
            $msg = ['status' => 200,'message' => 'Payment Successful'];
            break;
        case Payment::FAILED_STATUS:
            $msg = ['status' => 'failed','message' => 'Payment Failed'];
            break;
        case Payment::PENDING_STATUS:
            $msg = ['status' => 'pending','message' => 'Payment Pending'];
            break;
        case Payment::PARTIAL_STATUS:
            $msg = ['status' => 'partial','message' => 'Payment Partial'];
            break;
        case Payment::CURRENCY_MISMATCH_STATUS:
            $msg = ['status' => 'currency mismatch' ,'message' => 'Currency Mismatch'];
            break;
        
        default:
            $msg = ['message' => 'Payment could not be verified. Please contact support.'];
            break;
    }

    $response->getBody()->write($msg);
    return $response
              ->withHeader('Content-Type', 'application/json');

});



$app->post('/webhook', function (Request $request, Response $response) {
    
    $postData = json_decode(file_get_contents('php://input'), true);

    if (!$request->hasHeader('HTTP_VERIF_HASH')) {
        return 'You are not authorized to access this page';
    }

    $hash = $request->getHeader('HTTP_VERIF_HASH');
    if($hash != '12345'){
        return 'The Hash you have provided is invalid';
    }

    // verify the transaction and give value to the variables

        $endpoint_response = json_encode([ 'message' => 'Recieved Flutterwave Hook successfully']);
    $response->getBody()->write($endpoint_response);
    return $response
              ->withHeader('Content-Type', 'application/json');
});

$app->run();