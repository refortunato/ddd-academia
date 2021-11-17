
<?php

use Academia\Authentication\Controllers\UserController;
use Academia\Core\Adapters\SlimControllerAdapter;
use Academia\Core\Infra\Http\Slim\JsonBodyParserMiddleware;
use Academia\Register\Controllers\CustomerController;
use Academia\Subscription\Controllers\ServiceController;
use Academia\Subscription\Controllers\SubscriptionController;
use Academia\Subscription\Controllers\SubscriptionPlanController;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Log\LoggerInterface;
use Slim\Routing\RouteCollectorProxy;

$app = AppFactory::create();
// Convert To Json
$app->add(new JsonBodyParserMiddleware());


//Routes
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});
$app->get('/teste', function (Request $request, Response $response, $args) {
    $response->getBody()->write("<h1>Teste</h1>");
    return $response;
});

//Users
$app->post('/login', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->execute(UserController::class, 'login');
});
$app->map(['GET', 'POST'], '/is_authorized', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->execute(UserController::class, 'isAuthorized');
});
$app->post('/user', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(UserController::class, 'addUser');
});
$app->get('/user/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(UserController::class, 'getById');
});

//Customers
$app->post('/customer', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(CustomerController::class, 'add');
});
$app->get('/customer', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(CustomerController::class, 'getAll');
});
$app->get('/customer/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(CustomerController::class, 'getById');
});
$app->put('/customer/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(CustomerController::class, 'update');
});
$app->delete('/customer/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(CustomerController::class, 'delete');
});


//Services
$app->post('/service', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(ServiceController::class, 'add');
});
$app->put('/service/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(ServiceController::class, 'update');
});
$app->get('/service/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(ServiceController::class, 'getById');
});
$app->get('/service', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(ServiceController::class, 'getAll');
});
$app->delete('/service/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(ServiceController::class, 'delete');
});

//SubscriptionPlan
$app->post('/subscription-plan', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(SubscriptionPlanController::class, 'add');
});
$app->put('/subscription-plan/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(SubscriptionPlanController::class, 'update');
});
$app->delete('/subscription-plan/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(SubscriptionPlanController::class, 'delete');
});
$app->get('/subscription-plan', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(SubscriptionPlanController::class, 'getAll');
});
$app->get('/subscription-plan/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(SubscriptionPlanController::class, 'getById');
});

//Subscription
$app->post('/subscription', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(SubscriptionController::class, 'createSubscription');
});
$app->get('/subscription/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(SubscriptionController::class, 'getById');
});
$app->put('/subscription/cancel/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(SubscriptionController::class, 'cancel');
});
$app->put('/subscription/pay/{id}', function (Request $request, Response $response, $args) {
    return SlimControllerAdapter::create($request, $response, $args)->executeWithAuth(SubscriptionController::class, 'pay');
});

###############################
// Error Handler
###############################
// Define Custom Error Handler
$customErrorHandler = function (
    ServerRequestInterface $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails,
    ?LoggerInterface $logger = null
) use ($app) {
    if (! empty($logger)) {
        $logger->error($exception->getMessage());
    }

    $payload = ['error' => $exception->getMessage()];

    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_UNICODE)
    );

    return $response->withStatus($exception->getCode());
};
/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger  
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
//$errorHandler->forceContentType('application/json');
###############################
// End Error Handler
###############################

$app->run();



/*
//Auth Middleware Example:
$authenticationMiddleware = function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    $response_auth = new Slim\Psr7\Response();
    $response_auth = SlimControllerAdapter::create($request, $response_auth, [])->execute(UserController::class, 'isAuthorized');
    var_dump($response_auth->getStatusCode());
    if ($response_auth->getStatusCode() != 200) {
        return $response_auth
          ->withHeader('Content-Type', 'application/json')
          ->withStatus(401);
    }
    return $response;
};

//AuthenticationGroup
$app->group('', function (RouteCollectorProxy $group) {
    $group->get('/user/test/{id}', function (Request $request, Response $response, $args) {
        return SlimControllerAdapter::create($request, $response, $args)->execute(UserController::class, 'getById');
    });
})->add($authenticationMiddleware);
*/

