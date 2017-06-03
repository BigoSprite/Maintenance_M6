<?php
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// http://localhost:8888/
Route::get('/', function(){
    return redirect('http://221.236.173.192:8888/index.html');
});


Route::get('test', 'UserInfoController@test');

Route::group(['prefix'=>'api'],function (){

    /** new begin */
    Route::group(['prefix'=>'content'], function () {

        Route::get('realEstateInfo/{realEstateName}', 'RealEstateInfoController@getRealEstateInfo');
        Route::get('realEstateInfoList', 'RealEstateInfoController@getRealEstateInfoList');

        Route::group(['namespace'=>'Node'], function(){

            Route::get('verifyGprsID/{gprsid}', 'VDeviceInfoController@verifyGprsID');
            Route::get('deviceInformation','VDeviceInfoController@getDeviceInfoList');
            Route::get('deviceInformation/{gprsid}','VDeviceInfoController@getDeviceInfo');
            Route::get('deviceStatusList', 'VDeviceStatusController@getDeviceStatusList');
            Route::get('deviceStatus/{gprsid}', 'VDeviceStatusController@getDeviceStatus');

            Route::get('deviceRealTimeDataTable_headerData/{gprsid}','VDeviceRealTimeDataController@getTableHeader');
            Route::get('deviceRealTimeDataTable_bodyData/{gprsid}','VDeviceRealTimeDataController@getRealTimeData');

            Route::get('deviceHistoryDataTable_headerData/{gprsid}','VDeviceHistoryDataController@getTableHeader');
            Route::get('deviceHistoryDataTable_bodyData/{gprsid}','VDeviceHistoryDataController@getHistoryData');

            /** 注册 */
            Route::group(['prefix'=>'register'], function(){
                Route::post('device', 'VDeviceInfoController@registerDeviceInfo');
                Route::post('deviceStatus', 'VDeviceStatusController@registerDeviceStatus');

            });

            /** 验证 */
            Route::group(['prefix'=>'verify'], function(){


                Route::get('deviceStatus/{gprsId}', 'VDeviceStatusController@isGprsIdExist');
                Route::get('deviceRealTime/{gprsId}', 'VDeviceRealTimeDataController@isDeviceExist');

            });

            /** 更新 */
            Route::group(['prefix'=>'update'], function(){
                Route::post('deviceStatus', 'VDeviceStatusController@updateDeviceStatus');
            });

        });



    });
    /** new end */


    Route::group(['prefix'=>'admin'], function(){

        /** new begin */
        Route::get('login', 'UserInfoController@all');

        Route::get('nodeInfoList', 'NodeInfoController@all');
        Route::get('nodeNameList', 'NodeInfoController@getNodeNameList');
        Route::get('nodeServerInfo/{nodeName}', 'NodeInfoController@getNodeServerInfo');


        // 验证
        Route::group(['prefix'=>'verify'], function (){
            Route::post('login', 'UserInfoController@verifyLogin');
            Route::get('user/{userName}', 'UserInfoController@isUserNameExist');
            Route::get('node/{nodeName}', 'NodeInfoController@isNodeExist');
        });

        // 注册
        Route::group(['prefix'=>'register'], function(){
            Route::post('user', 'UserInfoController@registerUser');
            Route::post('realEstate', 'RealEstateInfoController@registerRealEstateInfo');
            Route::post('node', 'NodeInfoController@registerNodeInfo');
        });

        // 更新
        Route::group(['prefix'=>'update'], function(){
            Route::post('password', 'UserInfoController@updateUserPassword');
            Route::post('realEstate', 'RealEstateInfoController@updateRealEstateInfo');
            Route::post('node', 'NodeInfoController@updateNodeInfo');
        });

        /** new end */

        Route::group(['prefix'=>'verify1', 'namespace'=>'Center'], function(){

            Route::post('login', 'UserInfo_Controller@isUserExist');


            // http://localhost:8888/api/admin/verify/userName
            Route::post('userName', 'UserInfo_Controller@isUserNameExist');

        });



        Route::group(['prefix'=>'update1', 'namespace'=>'Center'], function(){

            // http://localhost:8888/api/admin/update/userInfo
            Route::post('userInfo', 'UserInfo_Controller@updateUserInfo');
            // http://localhost:8888/api/admin/update/userPassword
            Route::post('userPassword', 'UserInfo_Controller@updateUserPassword');
        });



    });




    Route::group(['prefix'=>'admin_BAK'], function(){

        Route::post('login', 'ComponentCommon\UserInfoController@isUserExist');

        Route::post('distributeRoomRegister', 'ComponentCenter\Distribution_Room_Controller@registerDistributionRoom');

        Route::post('deviceRegister', 'ComponentCenter\GmDevice_Information_Controller@registerDeviceInfo');
    });
});



//// TEST
///* ---------------------- AJAX POST Method---------------------------------------- */
//http://localhost:8888/ajaxPost
Route::get('ajaxPost', function (){
    return View::make('ajaxPostDemo');
});
//Route::post('ajaxPostUrl', 'AjaxController@responsePost');//->middleware('cors');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
