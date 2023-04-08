<?php





use Illuminate\Support\Facades\Route;



Route::get('/clear', function () {

    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

*/


Route::group(['middleware' => 'sessioncurrency'], function () {
    Route::namespace('Gateway')->prefix('ipn')->name('ipn.')->group(function () {

        Route::post('paypal', 'Paypal\ProcessController@ipn')->name('Paypal');

        Route::get('paypal-sdk', 'PaypalSdk\ProcessController@ipn')->name('PaypalSdk');

        Route::post('perfect-money', 'PerfectMoney\ProcessController@ipn')->name('PerfectMoney');

        Route::post('stripe', 'Stripe\ProcessController@ipn')->name('Stripe');

        Route::post('stripe-js', 'StripeJs\ProcessController@ipn')->name('StripeJs');

        Route::post('stripe-v3', 'StripeV3\ProcessController@ipn')->name('StripeV3');

        Route::post('skrill', 'Skrill\ProcessController@ipn')->name('Skrill');

        Route::post('paytm', 'Paytm\ProcessController@ipn')->name('Paytm');

        Route::post('payeer', 'Payeer\ProcessController@ipn')->name('Payeer');

        Route::post('paystack', 'Paystack\ProcessController@ipn')->name('Paystack');

        Route::post('voguepay', 'Voguepay\ProcessController@ipn')->name('Voguepay');

        Route::get('flutterwave/{trx}/{type}', 'Flutterwave\ProcessController@ipn')->name('Flutterwave');

        Route::post('razorpay', 'Razorpay\ProcessController@ipn')->name('Razorpay');

        Route::post('instamojo', 'Instamojo\ProcessController@ipn')->name('Instamojo');

        Route::get('blockchain', 'Blockchain\ProcessController@ipn')->name('Blockchain');

        Route::get('blockio', 'Blockio\ProcessController@ipn')->name('Blockio');

        Route::post('coinpayments', 'Coinpayments\ProcessController@ipn')->name('Coinpayments');

        // Route::post('coinpayments-fiat', 'Coinpayments_fiat\ProcessController@ipn')->name('CoinpaymentsFiat');

        Route::post('coingate', 'Coingate\ProcessController@ipn')->name('Coingate');

        Route::post('coinbase-commerce', 'CoinbaseCommerce\ProcessController@ipn')->name('CoinbaseCommerce');

        Route::get('mollie', 'Mollie\ProcessController@ipn')->name('Mollie');

        Route::post('cashmaal', 'Cashmaal\ProcessController@ipn')->name('Cashmaal');
    });



    // User Support Ticket

    Route::prefix('ticket')->group(function () {

        Route::get('/', 'TicketController@supportTicket')->name('ticket');

        Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');

        Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');

        Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');

        Route::post('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');

        Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
    });





    /*

|--------------------------------------------------------------------------

| Start Admin Area

|--------------------------------------------------------------------------

*/



    Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

        Route::namespace('Auth')->group(function () {

            Route::get('/', 'LoginController@showLoginForm')->name('login');
            Route::post('/', 'LoginController@login')->name('login');
            Route::get('logout', 'LoginController@logout')->name('logout');

            // Admin Password Reset

            Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');

            Route::post('password/reset', 'ForgotPasswordController@sendResetCodeEmail');

            Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify.code');

            Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.form');

            Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
        });



        Route::middleware('admin')->group(function () {

            Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');

            Route::get('profile', 'AdminController@profile')->name('profile');

            Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');

            Route::get('password', 'AdminController@password')->name('password');

            Route::post('password', 'AdminController@passwordUpdate')->name('password.update');



            //Bids

            Route::get('bids', 'AdminController@bids')->name('bids');


            // rewards page
            Route::get('rewards-page', 'AdminController@rewards_page')->name('rewards_page');
            Route::get('delete_c_rules/{id}', 'AdminController@delete_c_rules')->name('delete_c_rules');
            Route::get('delete_l_req/{id}', 'AdminController@delete_l_req')->name('delete_l_req');
            Route::post('store_lvl_req', 'AdminController@store_lvl_req')->name('store_lvl_req');
            Route::post('store_c_rule', 'AdminController@store_c_rule')->name('store_c_rule');

            // Game

            Route::post('game/update/{id}', 'GameController@update')->name('game.update');

            Route::post('nintyninegame/update/{id}', 'GameController@nintyninegameUpdate')->name('nintyninegame.update');







            //pool

            Route::get('game/pool', 'GameController@pool')->name('game.pool');



            //dice

            Route::get('game/dice', 'GameController@dice')->name('game.dice');



            //card

            Route::get('game/card', 'GameController@card')->name('game.card');



            //nintynine

            Route::get('game/nintynine', 'GameController@nintynine')->name('game.nintynine');



            //Roulette

            Route::get('game/roulette', 'GameController@roulette')->name('game.roulette');



            //Number Buy

            Route::get('game/numberbuy', 'GameController@numberbuy')->name('game.numberbuy');



            //Phase

            Route::get('phase', 'GameController@phase')->name('phase.index');

            Route::post('phase/create', 'GameController@phaseCreate')->name('phase.create');

            Route::post('phase/update/{id}', 'GameController@phaseUpdate')->name('phase.update');

            Route::post('phase/status/{id}', 'GameController@phaseStatus')->name('phase.status');



            //Manage Win

            Route::get('manage-win', 'ManageWinController@index')->name('win.index');

            Route::get('makeWinner/{id}', 'ManageWinController@makeWinner')->name('win.makeWinner');

            Route::post('bonus/calPool', 'ManageWinController@amoCalPool')->name('win.amoCalPool');

            Route::post('make/winner', 'ManageWinController@makeDraw')->name('win.makeDraw');

            Route::post('bonus/calDice', 'ManageWinController@amoCalDice')->name('win.amoCalDice');

            Route::post('make/winnerDice', 'ManageWinController@winnerDice')->name('win.winnerDice');

            Route::post('bonus/amoCalNumber', 'ManageWinController@amoCalNumber')->name('win.amoCalNumber');

            Route::post('make/winnerNumber', 'ManageWinController@winnerNumber')->name('win.winnerNumber');

            Route::post('bonus/calNum', 'ManageWinController@amoCalNum')->name('win.amoCalNum');

            Route::post('make/winnerNum', 'ManageWinController@winnerNum')->name('win.winnerNum');

            Route::post('bonus/calRoul', 'ManageWinController@amoCalRoul')->name('win.amoCalRoul');

            Route::post('make/winnerRoul', 'ManageWinController@winnerRoul')->name('win.winnerRoul');





            Route::post('make/winnerCard', 'ManageWinController@winnerCard')->name('win.winnerCard');

            Route::post('bonus/calCard', 'ManageWinController@calCard')->name('win.calCard');



            Route::get('winners', 'ManageWinController@winners')->name('win.winners');



            //refer

            Route::get('referral', 'AdminController@refIndex')->name('referral.index');

            Route::get('referral/commission-log', 'AdminController@commissionLog')->name('referral.commissionLog');

            Route::post('referral', 'AdminController@refStore')->name('store.refer');

            Route::post('setting/update', 'AdminController@settingUpdate')->name('setting.update.refer');

            Route::get('/referral-status/{type}', 'AdminController@referralStatusUpdate')->name('referral.status');













            //Notification

            Route::get('notifications', 'AdminController@notifications')->name('notifications');

            Route::get('notification/read/{id}', 'AdminController@notificationRead')->name('notification.read');

            Route::get('notifications/read-all', 'AdminController@readAll')->name('notifications.readAll');



            //Report Bugs

            Route::get('request-report', 'AdminController@requestReport')->name('request.report');

            Route::post('request-report', 'AdminController@reportSubmit');



            Route::get('system-info', 'AdminController@systemInfo')->name('system.info');


            //level pars

            Route::get('levelpars', 'ManageUsersController@levelpars')->name('level.pars');
            Route::get('levelpar/detail/{id}', 'ManageUsersController@levelpardetail')->name('levelpar.detail');
            Route::post('levelpar/update/{id}', 'ManageUsersController@levelparupdate')->name('levelpar.update');
            Route::post('/search_refs', 'ManageUsersController@search_refs')->name('search_refs');
            Route::post('addrefs_fil/{id}', 'ManageUsersController@addrefs_fil')->name('addrefs_fil');
            // Users Manager

            Route::get('users', 'ManageUsersController@allUsers')->name('users.all');

            Route::get('users/active', 'ManageUsersController@activeUsers')->name('users.active');

            Route::get('users/banned', 'ManageUsersController@bannedUsers')->name('users.banned');

            Route::get('users/email-verified', 'ManageUsersController@emailVerifiedUsers')->name('users.email.verified');

            Route::get('users/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.email.unverified');

            Route::get('users/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.sms.unverified');

            Route::get('users/sms-verified', 'ManageUsersController@smsVerifiedUsers')->name('users.sms.verified');

            Route::get('users/with-balance', 'ManageUsersController@usersWithBalance')->name('users.with.balance');



            Route::get('users/{scope}/search', 'ManageUsersController@search')->name('users.search');

            Route::get('user/detail/{id}', 'ManageUsersController@detail')->name('users.detail');

            Route::post('user/update/{id}', 'ManageUsersController@update')->name('users.update');

            Route::post('user/add-sub-balance/{id}', 'ManageUsersController@addSubBalance')->name('users.add.sub.balance');

            Route::get('user/send-email/{id}', 'ManageUsersController@showEmailSingleForm')->name('users.email.single');

            Route::post('user/send-email/{id}', 'ManageUsersController@sendEmailSingle')->name('users.email.single');

            Route::get('user/login/{id}', 'ManageUsersController@login')->name('users.login');

            Route::get('user/transactions/{id}', 'ManageUsersController@transactions')->name('users.transactions');

            Route::get('user/deposits/{id}', 'ManageUsersController@deposits')->name('users.deposits');

            Route::get('user/deposits/via/{method}/{type?}/{userId}', 'ManageUsersController@depositViaMethod')->name('users.deposits.method');

            Route::get('user/withdrawals/{id}', 'ManageUsersController@withdrawals')->name('users.withdrawals');

            Route::get('user/withdrawals/via/{method}/{type?}/{userId}', 'ManageUsersController@withdrawalsViaMethod')->name('users.withdrawals.method');

            // Login History

            Route::get('users/login/history/{id}', 'ManageUsersController@userLoginHistory')->name('users.login.history.single');



            //Wins

            Route::get('users/wins/{ip}', 'ManageUsersController@wins')->name('users.wins');



            Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');

            Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.send');

            Route::get('users/email-log/{id}', 'ManageUsersController@emailLog')->name('users.email.log');

            Route::get('users/email-details/{id}', 'ManageUsersController@emailDetails')->name('users.email.details');



            // Deposit Gateway

            Route::name('gateway.')->prefix('gateway')->group(function () {

                // Automatic Gateway

                Route::get('automatic', 'GatewayController@index')->name('automatic.index');

                Route::get('automatic/edit/{alias}', 'GatewayController@edit')->name('automatic.edit');

                Route::post('automatic/update/{code}', 'GatewayController@update')->name('automatic.update');

                Route::post('automatic/remove/{code}', 'GatewayController@remove')->name('automatic.remove');

                Route::post('automatic/activate', 'GatewayController@activate')->name('automatic.activate');

                Route::post('automatic/deactivate', 'GatewayController@deactivate')->name('automatic.deactivate');





                // Manual Methods

                Route::get('manual', 'ManualGatewayController@index')->name('manual.index');

                Route::get('manual/new', 'ManualGatewayController@create')->name('manual.create');

                Route::post('manual/new', 'ManualGatewayController@store')->name('manual.store');

                Route::get('manual/edit/{alias}', 'ManualGatewayController@edit')->name('manual.edit');

                Route::post('manual/update/{id}', 'ManualGatewayController@update')->name('manual.update');

                Route::post('manual/activate', 'ManualGatewayController@activate')->name('manual.activate');

                Route::post('manual/deactivate', 'ManualGatewayController@deactivate')->name('manual.deactivate');
            });





            // DEPOSIT SYSTEM

            Route::name('deposit.')->prefix('deposit')->group(function () {

                Route::get('/', 'DepositController@deposit')->name('list');

                Route::get('pending', 'DepositController@pending')->name('pending');

                Route::get('rejected', 'DepositController@rejected')->name('rejected');

                Route::get('approved', 'DepositController@approved')->name('approved');

                Route::get('successful', 'DepositController@successful')->name('successful');

                Route::get('details/{id}', 'DepositController@details')->name('details');



                Route::post('reject', 'DepositController@reject')->name('reject');

                Route::post('approve', 'DepositController@approve')->name('approve');

                Route::get('via/{method}/{type?}', 'DepositController@depositViaMethod')->name('method');

                Route::get('/{scope}/search', 'DepositController@search')->name('search');

                Route::get('date-search/{scope}', 'DepositController@dateSearch')->name('dateSearch');
            });





            // WITHDRAW SYSTEM

            Route::name('withdraw.')->prefix('withdraw')->group(function () {

                Route::get('pending', 'WithdrawalController@pending')->name('pending');

                Route::get('approved', 'WithdrawalController@approved')->name('approved');

                Route::get('rejected', 'WithdrawalController@rejected')->name('rejected');

                Route::get('log', 'WithdrawalController@log')->name('log');

                Route::get('via/{method_id}/{type?}', 'WithdrawalController@logViaMethod')->name('method');

                Route::get('{scope}/search', 'WithdrawalController@search')->name('search');

                Route::get('date-search/{scope}', 'WithdrawalController@dateSearch')->name('dateSearch');

                Route::get('details/{id}', 'WithdrawalController@details')->name('details');

                Route::post('approve', 'WithdrawalController@approve')->name('approve');

                Route::post('reject', 'WithdrawalController@reject')->name('reject');





                // Withdraw Method

                Route::get('method/', 'WithdrawMethodController@methods')->name('method.index');

                Route::get('method/create', 'WithdrawMethodController@create')->name('method.create');

                Route::post('method/create', 'WithdrawMethodController@store')->name('method.store');

                Route::get('method/edit/{id}', 'WithdrawMethodController@edit')->name('method.edit');

                Route::post('method/edit/{id}', 'WithdrawMethodController@update')->name('method.update');

                Route::post('method/activate', 'WithdrawMethodController@activate')->name('method.activate');

                Route::post('method/deactivate', 'WithdrawMethodController@deactivate')->name('method.deactivate');
            });



            // Report

            Route::get('report/transaction', 'ReportController@transaction')->name('report.transaction');

            Route::get('report/transaction/search', 'ReportController@transactionSearch')->name('report.transaction.search');

            Route::get('report/login/history', 'ReportController@loginHistory')->name('report.login.history');

            Route::get('report/login/ipHistory/{ip}', 'ReportController@loginIpHistory')->name('report.login.ipHistory');

            Route::get('report/email/history', 'ReportController@emailHistory')->name('report.email.history');





            // Admin Support

            Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');

            Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');

            Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');

            Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');

            Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');

            Route::post('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply');

            Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');

            Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete');





            // Language Manager

            Route::get('/language', 'LanguageController@langManage')->name('language.manage');

            Route::post('/language', 'LanguageController@langStore')->name('language.manage.store');

            Route::post('/language/delete/{id}', 'LanguageController@langDel')->name('language.manage.del');

            Route::post('/language/update/{id}', 'LanguageController@langUpdate')->name('language.manage.update');

            Route::get('/language/edit/{id}', 'LanguageController@langEdit')->name('language.key');

            Route::post('/language/import', 'LanguageController@langImport')->name('language.importLang');







            Route::post('language/store/key/{id}', 'LanguageController@storeLanguageJson')->name('language.store.key');

            Route::post('language/delete/key/{id}', 'LanguageController@deleteLanguageJson')->name('language.delete.key');

            Route::post('language/update/key/{id}', 'LanguageController@updateLanguageJson')->name('language.update.key');







            // General Setting

            Route::get('general-setting', 'GeneralSettingController@index')->name('setting.index');

            Route::post('general-setting', 'GeneralSettingController@update')->name('setting.update');

            Route::get('optimize', 'GeneralSettingController@optimize')->name('setting.optimize');



            // Logo-Icon

            Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo.icon');

            Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo.icon');



            //Custom CSS

            Route::get('custom-css', 'GeneralSettingController@customCss')->name('setting.custom.css');

            Route::post('custom-css', 'GeneralSettingController@customCssSubmit');





            //Custom CSS

            Route::get('cookie', 'GeneralSettingController@cookie')->name('setting.cookie');

            Route::post('cookie', 'GeneralSettingController@cookieSubmit');





            // Plugin

            Route::get('extensions', 'ExtensionController@index')->name('extensions.index');

            Route::post('extensions/update/{id}', 'ExtensionController@update')->name('extensions.update');

            Route::post('extensions/activate', 'ExtensionController@activate')->name('extensions.activate');

            Route::post('extensions/deactivate', 'ExtensionController@deactivate')->name('extensions.deactivate');







            // Email Setting

            Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email.template.global');

            Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('email.template.global');

            Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email.template.setting');

            Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('email.template.setting');

            Route::get('email-template/index', 'EmailTemplateController@index')->name('email.template.index');

            Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email.template.edit');

            Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email.template.update');

            Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email.template.test.mail');





            // SMS Setting

            Route::get('sms-template/global', 'SmsTemplateController@smsTemplate')->name('sms.template.global');

            Route::post('sms-template/global', 'SmsTemplateController@smsTemplategUpdate')->name('sms.template.global');

            Route::get('sms-template/setting', 'SmsTemplateController@smsSetting')->name('sms.templates.setting');

            Route::post('sms-template/setting', 'SmsTemplateController@smsSettingUpdate')->name('sms.template.setting');

            Route::get('sms-template/index', 'SmsTemplateController@index')->name('sms.template.index');

            Route::get('sms-template/edit/{id}', 'SmsTemplateController@edit')->name('sms.template.edit');

            Route::post('sms-template/update/{id}', 'SmsTemplateController@update')->name('sms.template.update');

            Route::post('email-template/send-test-sms', 'SmsTemplateController@sendTestSMS')->name('sms.template.test.sms');



            // User Roles

            Route::get('user-roles/all', 'UserRolesController@index')->name('roles.permissions.index');
            Route::get('user-roles/edit/{id}', 'UserRolesController@edit')->name('roles.permissions.edit');
            Route::post('user-roles/update/{id}', 'UserRolesController@update')->name('roles.permissions.update');
            Route::get('user-roles/create', 'UserRolesController@create')->name('roles.permissions.create');



            // SEO

            Route::get('seo', 'FrontendController@seoEdit')->name('seo');





            Route::get('raffle', 'RaffleController@index')->name('raffle.index');
            Route::get('raffle/winnings', 'RaffleController@winnings')->name('raffle.winnings');
            // Route::get('raffle/delete_tickets', 'RaffleController@delete_tickets')->name('raffle.delete_tickets');

            Route::get('raffle/create', 'RaffleController@create')->name('raffle.create');

            Route::post('raffle/store', 'RaffleController@store')->name('raffle.store');

            Route::get('raffle/{id}/edit', 'RaffleController@edit')->name('raffle.edit');

            Route::post('raffle/{id}/update', 'RaffleController@update')->name('raffle.update');

            Route::get('raffle/{id}/delete', 'RaffleController@delete')->name('raffle.delete');

            Route::get('raffle/{id}/manage-winners', 'AdminController@manage_winners')->name('raffle.manage_winners');

            Route::get('raffle/{id}/delete-winner', 'AdminController@delete_winner')->name('raffle.delete_winner');

            Route::post('raffle/{id}/store-winners', 'AdminController@store_winners')->name('raffle.store_winners');

            Route::get('draw-winners', 'RaffleController@draw_winners')->name('raffle.draw_winners');







            Route::get('raffle/{id}/free_offer', 'RaffleController@freeOffer')->name('raffle.free_offer');

            Route::post('raffle/{id}/free_offer/store', 'RaffleController@freeOfferStore')->name('raffle.free_offer.store');

            Route::post('raffle/{id}/free_offer/update', 'RaffleController@freeOfferUpdate')->name('raffle.free_offer.update');

            Route::post('raffle/{id}/free_offer/delete', 'RaffleController@freeOfferDelete')->name('raffle.free_offer.delete');







            Route::get('currencies/', 'FrontendController@currencyread')->name('currencies.read');

            Route::get('currencies/create', 'FrontendController@currencycreateForm')->name('currencies.create.form');

            Route::post('currencies/create', 'FrontendController@currencycreate')->name('currencies.create');

            Route::get('currencies/{id}/update', 'FrontendController@currencyeditForm')->name('currencies.edit.form');

            Route::post('currencies/{id}/update', 'FrontendController@currencyedit')->name('currencies.edit');

            Route::get('currencies/{id}/delete', 'FrontendController@currencydelete')->name('currencies.delete');





            Route::get('testcronwinner', 'RaffleController@draw_winnerss')->name('draw_winnerss');
            Route::get('winning_segments/{id}', 'RaffleController@winningSegments')->name('winning_segments');

            Route::get('winning_segments/{id}/delete', 'RaffleController@winningSegmentsDelete')->name('winning_segments.delete');

            Route::post('winning_segments/{id}/store', 'RaffleController@winningSegmentStore')->name('winning_segments.store');

            Route::post('raffle/{id}/update', 'RaffleController@update')->name('raffle.update');





            Route::get('free_ticket', 'FreeTicketController@index')->name('free_ticket.index');

            Route::get('free_ticket/create', 'FreeTicketController@create')->name('free_ticket.create');

            Route::post('free_ticket/store', 'FreeTicketController@store')->name('free_ticket.store');

            Route::get('free_ticket/{id}/edit', 'FreeTicketController@edit')->name('free_ticket.edit');

            Route::get('free_ticket/{id}/update', 'FreeTicketController@update')->name('free_ticket.update');

            // Raffle Game Free ticket



            Route::resource('reffle/free-ticket', RaffleGameFreeTicketController::class);











            //RaffleDraw

            Route::get('raffle/category', 'RaffleCategoryController@getCategoryList')->name('raffle.category');

            Route::get('raffle/category/{id}/edit', ['as' => 'raffle.category.edit', 'uses' => 'RaffleCategoryController@getCategoryEdit']);

            Route::post('raffle/category/{id}/update', ['as' => 'raffle.category.update', 'uses' => 'RaffleCategoryController@categoryUpdate']);



            //scratch card

            Route::get('scratch-card/category', 'RaffleCategoryController@getscratchCategoryList')->name('scratch.category');

            Route::get('scratch-card/category/{id}/edit', ['as' => 'scratch.category.edit', 'uses' => 'RaffleCategoryController@getscratchCategoryEdit']);

            Route::post('scratch-card/category/{id}/update', ['as' => 'scratch.category.update', 'uses' => 'RaffleCategoryController@scratchcategoryUpdate']);





            Route::get('scratch-card', 'RaffleController@scratch')->name('scratch.index');

            Route::get('scratch-card/create', 'RaffleController@createscratch')->name('scratch.create');

            Route::post('scratch-card/store', 'RaffleController@storescratch')->name('scratch.store');

            Route::get('scratch-card/{id}/edit', 'RaffleController@editscratch')->name('scratch.edit');

            Route::post('scratch-card/{id}/update', 'RaffleController@updatescratch')->name('scratch.update');

            Route::get('scratch-card/{id}/delete', 'RaffleController@deletescratch')->name('scratch.delete');

            Route::get('scratch-card/paytable/{id}', 'RaffleController@showpaytable')->name('paytable.show');

            // Paytable



            Route::get('paytable/create/{id?}', 'RaffleController@createpaytable')->name('paytable.create');

            Route::post('paytable/store', 'RaffleController@storepaytable')->name('paytable.store');

            Route::get('paytable/{id?}', 'RaffleController@paytable')->name('paytable.index');

            Route::get('paytable/{id}/edit', 'RaffleController@editpaytable')->name('paytable.edit');

            Route::post('paytable/{id}/update', 'RaffleController@updatepaytable')->name('paytable.update');

            Route::get('paytable/{id}/delete', 'RaffleController@deletepaytable')->name('paytable.delete');







            // Frontend

            Route::name('frontend.')->prefix('frontend')->group(function () {



                Route::get('templates', 'FrontendController@templates')->name('templates');

                Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');



                Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');

                Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');

                Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');

                Route::post('remove', 'FrontendController@remove')->name('remove');



                // Page Builder

                Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');

                Route::post('manage-pages', 'PageBuilderController@managePagesSave')->name('manage.pages.save');

                Route::post('manage-pages/update', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');

                Route::post('manage-pages/delete', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');

                Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');

                Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
            });
        });
    });









    /*

|--------------------------------------------------------------------------

| Start User Area

|--------------------------------------------------------------------------

*/





    Route::name('user.')->group(function () {

        Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');

        Route::post('/login', 'Auth\LoginController@login');

        Route::get('logout', 'Auth\LoginController@logout')->name('logout');



        Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');

        Route::post('register', 'Auth\RegisterController@register')->middleware('regStatus');

        Route::post('check-mail', 'Auth\RegisterController@checkUser')->name('checkUser');



        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetCodeEmail')->name('password.email');

        Route::get('password/code-verify', 'Auth\ForgotPasswordController@codeVerify')->name('password.code.verify');

        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

        Route::post('password/verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('password.verify.code');
    });



    Route::name('user.')->prefix('user')->group(function () {

        Route::middleware('auth')->group(function () {

            Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');

            Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send.verify.code');

            Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify.email');

            Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify.sms');

            Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');



            Route::middleware(['checkStatus'])->group(function () {

                Route::get('dashboard', 'UserController@home')->name('home');

                Route::get('scratch-card', 'UserController@scratch_cards')->name('user.scratch_cards');

                Route::get('wallet', 'UserController@wallet')->name('wallet');

                Route::post('buy-ticket/{id}', 'SiteController@buyticket')->name('buyticket');

                Route::post('buy-scratch-ticket/{id}', 'SiteController@buyscratchticket')->name('buyscratchticket');



                Route::get('profile-setting', 'UserController@profile')->name('profile.setting');

                Route::post('profile-setting', 'UserController@submitProfile');

                Route::get('change-password', 'UserController@changePassword')->name('change.password');

                Route::post('change-password', 'UserController@submitPassword');



                //2FA

                Route::get('twofactor', 'UserController@show2faForm')->name('twofactor');

                Route::post('twofactor/enable', 'UserController@create2fa')->name('twofactor.enable');

                Route::post('twofactor/disable', 'UserController@disable2fa')->name('twofactor.disable');



                //Games

                Route::get('play-game/{id}', 'PlayController@playGame')->name('game.play');

                Route::post('cardBid', 'PlayController@cardBid')->name('game.cardBid');

                Route::post('diceBid', 'PlayController@diceBid')->name('game.diceBid');

                Route::post('poolBid', 'PlayController@poolBid')->name('game.poolBid');

                Route::post('numberBid', 'PlayController@numberBid')->name('game.numberBid');

                Route::post('rouletteBid', 'PlayController@rouletteBid')->name('game.rouletteBid');

                Route::post('buyNumberBid', 'PlayController@buyNumberBid')->name('game.buyNumberBid');



                // Deposit

                Route::any('/deposit', 'Gateway\PaymentController@deposit')->name('deposit');

                Route::post('deposit/insert', 'Gateway\PaymentController@depositInsert')->name('deposit.insert');

                // junaid start

                Route::post('deposit/submit', 'Gateway\PaymentController@depositSubmit')->name('deposit.submit');

                // junaid end

                Route::get('deposit/preview', 'Gateway\PaymentController@depositPreview')->name('deposit.preview');

                Route::get('deposit/confirm', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');

                Route::get('deposit/manual', 'Gateway\PaymentController@manualDepositConfirm')->name('deposit.manual.confirm');

                Route::post('deposit/manual', 'Gateway\PaymentController@manualDepositUpdate')->name('deposit.manual.update');

                Route::get('deposit/history', 'UserController@depositHistory')->name('deposit.history');

                Route::get('raffle-tickets', 'UserController@raffle_tickets')->name('raffle_tickets');
                Route::get('my-scratch-cards', 'UserController@my_scratch_cards')->name('my_scratch_cards');
                Route::get('scratch-card-wins', 'UserController@my_scratch_wins')->name('my_scratch_wins');
                Route::get('raffle-wins', 'UserController@rafflewins')->name('rafflewins');
                Route::get('raffle-games', 'UserController@raffledraw')->name('raffle_games');



                // Withdraw

                Route::get('/withdraw', 'UserController@withdrawMoney')->name('withdraw');

                Route::post('/withdraw', 'UserController@withdrawStore')->name('withdraw.money');

                Route::get('/withdraw/preview', 'UserController@withdrawPreview')->name('withdraw.preview');

                Route::post('/withdraw/preview', 'UserController@withdrawSubmit')->name('withdraw.submit');

                Route::get('/withdraw/history', 'UserController@withdrawLog')->name('withdraw.history');



                // Bids

                Route::get('bids', 'UserController@bids')->name('bids');



                // Wins

                Route::get('wins', 'UserController@wins')->name('wins');



                // Commissions

                Route::get('commissions', 'UserController@commissions')->name('commissions');



                // Transaction

                Route::get('transactions', 'UserController@transactions')->name('transactions');

                Route::get('referral', 'UserController@referral')->name('referral');



                Route::post('add-Winning-Points', 'UserController@addWinningPoints')->name('addWinningPoints');
            });
        });
    });

    Route::get('/exchange_rate', 'SiteController@exchange_rate')->name('exchange_rate');


    Route::get('/download-app', 'SiteController@downloadAndroidApp')->name('download-app');




    Route::get('/raffle-draw', 'SiteController@raffleDraw')->name('raffle-draw');

    Route::get('/raffle-draw/{id}', 'SiteController@raffleDrawDetails')->name('raffle-draw-details');

    Route::get('/raffle-draw-free', 'SiteController@raffleDrawFree')->name('raffleDrawFree');







    Route::get('/scratch-cards', 'SiteController@scratchcards')->name('scratch-cards');

    Route::get('/scratch-cards-game/{id}', 'SiteController@scratchcards_game')->name('scratch_cards_game');

    Route::get('/lottery', 'SiteController@lottery')->name('lottery');

    Route::get('/rewards', 'SiteController@rewards')->name('rewards');





    Route::get('/contact', 'SiteController@contact')->name('contact');

    Route::post('/contact', 'SiteController@contactSubmit');




    Route::get('/change/{lang?}', 'SiteController@changeLanguage')->name('lang');



    Route::get('/changeCurrency/{currency?}', 'SiteController@changeCurrency')->name('currency.change');



    Route::get('/cookie/accept', 'SiteController@cookieAccept')->name('cookie.accept');



    Route::get('links/{id}/{slug}', 'SiteController@links')->name('links');



    Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholder.image');





    Route::get('/new_page', 'SiteController@new_page')->name('new_page');
    Route::get('/{slug}', 'SiteController@pages')->name('pages');

    // Route::get('/batch_insert', 'SiteController@batch_insert')->name('batch_insert');
    // Route::get('/', 'SiteController@index')->name('home');
    Route::get('/', 'SiteController@index')->name('home');
});
