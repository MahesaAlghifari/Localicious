<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\GeofenceLogController;
use App\Http\Controllers\Api\GeofencingNotificationController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\MidtransTransactionController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\RestaurantAdminController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\RestaurantPaymentAccountController;
use App\Http\Controllers\Api\RestaurantPolygonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('restaurants', RestaurantController::class);
Route::apiResource('restaurant-admins', RestaurantAdminController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('menus', MenuController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-items', OrderItemController::class);
Route::apiResource('payments', RestaurantPaymentAccountController::class);
Route::apiResource('notifications', NotificationController::class);
Route::apiResource('restaurant-polygons', RestaurantPolygonController::class);
Route::apiResource('geofencing-notifications', GeofencingNotificationController::class);
Route::apiResource('restaurant-payment-accounts', RestaurantPaymentAccountController::class);
Route::apiResource('midtrans-transactions', MidtransTransactionController::class);
Route::apiResource('geofence-logs', GeofenceLogController::class);



// routes/api.php
Route::post('/payment-token', [PaymentController::class, 'getSnapToken']);
Route::post('/payment/callback', [PaymentController::class, 'handleCallback']);