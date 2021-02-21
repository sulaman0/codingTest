<?php

use App\Http\Controllers\DemoAccount\DemoAccountController;
use App\Http\Controllers\Home\HomeController;
use App\Mail\DemoAccountRequest\SendEmailToReceiver;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

## serve home page.
Route::get('/', [HomeController::class, 'index'])->name('home');
## send transfer amount
Route::post('/transfer-amount', [HomeController::class, 'transferAmount'])->name('transfer_amount');
Route::get(
    'test',
    function () {
        //        $response = \App\Models\UserModel\UserModel::decreaseCurrentBalance(91, 2);
        $response = \App\Models\UserModel\UserModel::increaseCurrentBalance(100, 3);
        dump($response);
    }
);
