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

Route::get('install', 'InstallerController@installApplication')->name('application.install');
Route::post('install', 'InstallerController@setConfigurations')->name('application.setConfigurations');

Route::group([
    'middleware' => 'installed'
], function () {
    Route::group([
        'middleware' => 'auth'
    ], function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');

        #region AccountController
        Route::get('/my-account', 'AccountController@myAccount')->name('account.manage');
        Route::post('/my-account', 'AccountController@storeAccountChanges')->name('account.update');

        #endregion
        #region TemplateController
        Route::get('/template/{template}/variables', 'TemplateController@variables')->name('template.variables');
        Route::resource('template', 'TemplateController');

        #endregion
        #region DocumentController
        Route::resource('document', 'DocumentController');
        Route::post('/document/preview', 'DocumentController@preview')->name('document.preview');
        Route::get('/document/{document}/download', 'DocumentController@download')->name('document.download');

        #endregion
        #region VariableController
        Route::resource('variable', 'VariableController');

        #endregion
        #region PDFController
        Route::get('/pdf/preview-template/{template}', 'PDFController@viewTemplate')->name('pdf.template');
        Route::get('/pdf/document/{template}', 'PDFController@viewDocument')->name('pdf.document');
        Route::post('/pdf/preview', 'PDFController@previewPDFOutput')->name('pdf.preview');

        #endregion
        #region FileController
        Route::resource('file', 'FileController');
        Route::get('files', 'FileController@index')->name('files');

        #endregion
        #region MediaController
        Route::get('media', 'MediaController@media')->name('media');

        #endregion
        #region ViewLinkController
        Route::post('view-link', 'ViewLinkController@store')->name('viewlink.store');
        Route::delete('view-link/{viewLink}', 'ViewLinkController@destroy')->name('viewlink.destroy');
        Route::get('view-document/{fakepath}', 'ViewLinkController@show')->name('viewlink.show');

        #endregion
        #region Users

        #endregion
        #region Settings
        Route::get('settings', 'SettingsController@index')->name('settings');

        #endregion
    });


    #region ViewLinkController
    Route::get('view-document/{fakepath}', 'ViewLinkController@show')->name('viewlink.show');

    #endregion
    #region SignerController
    Route::resource('signer', 'SignerController');
    Route::post('sign-document/{signer}', 'SignerController@requestAccess')->name('signer.requestAccess');
    Route::get('sign-document/{signer}', 'SignerController@show');

    #endregion

    Auth::routes([
        'register'  => true,
    ]);
});