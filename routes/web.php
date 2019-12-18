<?php

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
Route::group(['prefix' => 'front' , 'namespace' => 'Front'] , function()
{
    Route::get('/home', 'MainController@home');


    Route::get('/login', 'AuthController@login')->name('client_login_page');
    Route::post('/login' , 'AuthController@login_submit')->name('client_login');

    Route::get('/register', 'AuthController@register');

    Route::post('/register' , 'AuthController@register_submit')->name('client_register');
    Route::post('/logout' , 'AuthController@logout')->name('client-logout');

    Route::get('forget_password' , 'AuthController@forget_password');
    Route::post('forget_password' , 'AuthController@forget_password_submit');
    Route::get('change_password' , 'AuthController@change_password');
    Route::post('change_password' , 'AuthController@change_password_submit');
    

    Route::group(['middleware' => 'auth:client-web'] , function()
    {
       
        Route::get('/about', 'MainController@about');
        Route::get('/contact', 'MainController@contact');
        Route::post('/contact' , 'MainController@contact_submit')->name('client_contact');
        Route::get('/donations', 'MainController@donations');
        Route::get('/donation_search', 'MainController@donation_search')->name('donation_search');
        Route::get('donation_details/{donation}' , 'MainController@donation_show')->name('donation_details');
        Route::get('donation_create' , 'MainController@donation_create')->name('donation_create');
        Route::post('donation_create' , 'MainController@donation_create_submit')->name('donation_create_submit');
        Route::get('/posts' , 'MainController@posts');
        Route::get('/favourite_posts' , 'MainController@favourite_posts');
        Route::get('post/{post}' , 'MainController@post_show')->name('post_details');
        Route::post('/toggle' , 'MainController@toggleFavourite')->name('toggle-favourite');
        Route::match(['get', 'put'] ,'profile'                ,'AuthController@profile');
        Route::match(['get', 'put'] ,'notification_settings'                ,'AuthController@notification_settings');
        Route::get('notifications' , 'AuthController@notifications');
    });
});


Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


Route::group(['middleware' => ['auth' , 'auto-check-permission'] , 'prefix' => 'admin'] , function()
{
    Route::get     ('/home'             , 'HomeController@index')->name('home');
    Route::resource('governorate'       , 'GovernorateController');
    Route::resource('city'              , 'CityController');
    Route::resource('category'          , 'CategoryController');
    Route::resource('client'            , 'ClientController');
    Route::get     ('search'            , 'ClientController@search');
    Route::post    ('client_activation/{client}'   , 'ClientController@activation')->name('activation');
    Route::resource('post'              , 'PostController');
    Route::resource('contact'           , 'ContactController');
    Route::resource('donation'          , 'DonationRequestController');
    Route::get     ('search_in_donation', 'DonationRequestController@search');
    Route::resource('setting'           , 'SettingController');
    Route::get     ('changePassword'    , 'AdminController@change_password_form')->name('changePassword');
    Route::post    ('changePassword'    , 'AdminController@change_password_submit')->name('submitChangePassword');
    Route::resource('role'              , 'RoleController');
    Route::resource('user'              , 'UserController');
});
