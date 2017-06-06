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



Route::get('test/{nodeName}', 'RealEstateInfoController@getRealEstateWithDBInfoList');
Route::get('test', 'NodeInfoController@getNodeListWithChildren');


Route::group(['prefix'=>'api'],function (){

    Route::group(['prefix'=>'content'], function () {

        Route::get('realEstateInfo/{realEstateName}', 'RealEstateInfoController@getRealEstateInfo');
        Route::get('realEstateInfoList', 'RealEstateInfoController@getRealEstateInfoList');

        // 验证
        Route::group(['prefix'=>'verify'], function (){
            Route::get('realEstate/{dbName}', 'RealEstateInfoController@isRealEstateExist');
        });

        Route::group(['namespace'=>'Node'], function(){

            Route::get('deviceInformation','VDeviceInfoController@getDeviceInfoList');
            Route::get('deviceInformation/{gprsid}','VDeviceInfoController@getDeviceInfo');
            Route::get('deviceStatusList', 'VDeviceStatusController@getDeviceStatusList');
            Route::get('deviceStatus/{gprsid}', 'VDeviceStatusController@getDeviceStatus');

            Route::get('deviceRealTimeDataTable_headerData/{gprsid}','VDeviceRealTimeDataController@getTableHeader');
            Route::get('deviceRealTimeDataTable_bodyData/{gprsid}','VDeviceRealTimeDataController@getRealTimeData');

            Route::get('deviceHistoryDataTable_headerData/{gprsid}','VDeviceHistoryDataController@getTableHeader');
            Route::get('deviceHistoryDataTable_bodyData/{gprsid}','VDeviceHistoryDataController@getHistoryData');


            Route::get('deviceNodeInfo/{nodeName}', 'VDeviceNodeInfoController@getNodeInfo');
            Route::get('deviceNodeInfoList', 'VDeviceNodeInfoController@getNodeList');

            Route::get('node/realEstateInfo/{dbName}', 'Real_Estate_Info_Controller@get_Real_Estate_Info');
            Route::get('node/realEstateInfoList', 'Real_Estate_Info_Controller@get_Real_Estate_Info_List');

            /** 注册 */
            Route::group(['prefix'=>'register'], function(){
                Route::post('device', 'VDeviceInfoController@registerDeviceInfo');
                Route::post('deviceStatus', 'VDeviceStatusController@registerDeviceStatus');
                Route::post('node/realEstateInfo', 'Real_Estate_Info_Controller@register_Real_Estate_Info');

            });

            /** 验证 */
            Route::group(['prefix'=>'verify'], function(){

                Route::get('deviceStatus/{gprsId}', 'VDeviceStatusController@isGprsIdExist');
                Route::get('deviceRealTime/{gprsId}', 'VDeviceRealTimeDataController@isDeviceExist');
                Route::get('deviceInfo/{gprsId}', 'VDeviceInfoController@isGprsIdExist');

                Route::get('deviceNodeInfo/{nodeName}', 'VDeviceNodeInfoController@isNodeExist');
                Route::get('node/realEstateInfo/{dbName}', 'Real_Estate_Info_Controller@isDBNameExist');

            });

            /** 更新 */
            Route::group(['prefix'=>'update'], function(){
                Route::post('deviceStatus', 'VDeviceStatusController@updateDeviceStatus');
                Route::post('device', 'VDeviceInfoController@updateDeviceInfo');
                Route::post('node/realEstateInfo', 'Real_Estate_Info_Controller@update_Real_Estate_Info');
            });

        });

        Route::group(['namespace'=>'Client'], function (){

            Route::get('distributionRoomInfo/{serialId}', 'DistributionRoomInfoController@getRoomInfo');
            Route::get('distributionRoomInfoList', 'DistributionRoomInfoController@getRoomInfoList');
            Route::get('distributionRoomNameList/serialId', 'DistributionRoomInfoController@getRoomNameListWithSerialId');

            Route::get('assetInfoList', 'AssetInfoController@getAssetInfoList');

            Route::get('deviceTypeInfo/{typeName}', 'VDeviceTypeInfoController@getDeviceTypeInfo');
            Route::get('deviceTypeInfoList', 'VDeviceTypeInfoController@getDeviceTypeInfoList');

            // 验证
            Route::group(['prefix'=>'verify'], function (){
                Route::get('distributionRoom/{serialId}', 'DistributionRoomInfoController@isRoomExist');
                Route::get('deviceType/{typeName}', 'VDeviceTypeInfoController@isDeviceTypeExist');
            });
            // 注册
            Route::group(['prefix'=>'register'], function(){
                Route::post('distributionRoom', 'DistributionRoomInfoController@registerRoom');
                Route::post('asset', 'AssetInfoController@registerAssetInfo');
                Route::post('deviceTypeInfo', 'VDeviceTypeInfoController@registerDeviceType');
            });
            // 更新
            Route::group(['prefix'=>'update'], function(){
                Route::post('distributionRoom', 'DistributionRoomInfoController@updateRoom');
                Route::post('deviceTypeInfo', 'VDeviceTypeInfoController@updateDeviceType');
            });
        });

    });

    Route::group(['prefix'=>'admin'], function(){

        Route::get('userInfoList', 'UserInfoController@all');

        Route::get('nodeInfoList', 'NodeInfoController@all');
        Route::get('nodeNameList', 'NodeInfoController@getNodeNameList');
        Route::get('nodeServerInfo/{nodeName}', 'NodeInfoController@getNodeServerInfo');

        Route::get('nodeTreeInfo', 'NodeInfoController@getNodeTree');

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
