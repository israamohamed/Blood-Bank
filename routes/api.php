<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//'AuthController@register'
Route::group(['prefix' => 'v1' , 'namespace' => 'Api'] , function(){
    Route::post('register' , 'AuthController@register');
    Route::post('login'    , 'AuthController@login');
    Route::post('newPassword', 'AuthController@newPassword');
    Route::post('resetPassword', 'AuthController@resetPassword');
    

    Route::get('governorates' , 'MainController@governorates');
    Route::get('cities' , 'MainController@cities');
    Route::get('categories' , 'MainController@categories');
    Route::get('bloodTypes' , 'MainController@bloodTypes');
    Route::get('settings'   , 'MainController@settings');



    Route::group(['middleware' => 'auth:api'] , function(){
        Route::get  (                'posts'                  ,'MainController@posts');
        Route::get  (                'post'                   ,'MainController@post');
        Route::post (                'contacts'               ,'MainController@contacts');
        Route::match(['get', 'put'] ,'profile'                ,'AuthController@profile');
        Route::match(['get', 'put'] ,'notificationSettings'   ,'AuthController@notificationSettings');
        Route::get  (                'listFavourites'         ,'MainController@listFavourites');
        Route::get  (                'toggleFavourite'        ,'MainController@toggleFavourite');
        Route::get  (                'donationRequests'       ,'MainController@donationRequests');
        Route::get  (                'donationRequest'        ,'MainController@donationRequest');
        Route::post (                'createDonationRequest'  ,'MainController@donationRequestCreate');
        Route::post(                 'registerToken'          ,'AuthController@registerToken');
        Route::post(                 'removeToken'            ,'AuthController@removeToken'   );
        Route::get  (                'unreadNotificationCount','AuthController@unreadNotificationCount');
        Route::get  (                'listNotifications'      ,'MainController@listNotifications');
        
    });
    
});


//api/v1/..