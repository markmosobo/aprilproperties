<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ListController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ConditionController;
use App\Http\Controllers\Api\FurnishingController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PropertyTypeController;
use App\Http\Controllers\Api\BlogCategoryController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\SocialLinkController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\LandlordController;
use App\Http\Controllers\Api\PmsPropertyController;
use App\Http\Controllers\Api\PmsUnitController;
use App\Http\Controllers\Api\PmsTenantController;
use App\Http\Controllers\Api\PmsExpenseController;
use App\Http\Controllers\Api\PmsYearController;
use App\Http\Controllers\Api\PmsStatementController;
use App\Http\Controllers\Api\PmsInvoiceController;
use App\Http\Controllers\Api\ReceiptController;
use App\Http\Controllers\Api\ReminderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users', [UserController::class, 'store']);
Route::post('properties', [PropertyController::class, 'store']);
Route::post('pmsproperties', [PmsPropertyController::class, 'store']);
Route::post('categories', [CategoryController::class, 'store']);
Route::post('blogcategories', [BlogCategoryController::class, 'store']);
Route::post('blogs', [BlogController::class, 'store']);
Route::post('roles', [RoleController::class, 'store']);
Route::post('conditions', [ConditionController::class, 'store']);
Route::post('furnishings', [FurnishingController::class, 'store']);
Route::post('locations', [LocationController::class, 'store']);
Route::post('abouts', [AboutController::class, 'store']);
Route::post('services', [ServiceController::class, 'store']);
Route::post('contacts', [ContactController::class, 'store']);
Route::post('payment', [PaymentController::class, 'store']);
Route::post('sociallinks', [SocialLinkController::class, 'store']);
Route::post('messages', [MessageController::class, 'store']);
Route::post('projects', [ProjectController::class, 'store']);
Route::post('landlords', [LandlordController::class, 'store']);
Route::post('tenants', [PmsTenantController::class, 'store']);
Route::post('pmsexpenses', [PmsExpenseController::class, 'store']);
Route::post('pmsstatements', [PmsStatementController::class, 'store']);
Route::post('pmsunits/{id}', [PmsUnitController::class, 'store']);
//create invoice
Route::post('pmsinvoicestatement', [PmsStatementController::class, 'createInvoice']);

Route::get('users', [UserController::class, 'index']);
Route::get('properties', [PropertyController::class, 'index']);
Route::get('propertytypes', [PropertyTypeController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('blogcategories', [BlogCategoryController::class, 'index']);
Route::get('blogs', [BlogController::class, 'index']);
Route::get('roles', [RoleController::class, 'index']);
Route::get('conditions', [ConditionController::class, 'index']);
Route::get('furnishings', [FurnishingController::class, 'index']);
Route::get('locations', [LocationController::class, 'index']);
Route::get('abouts', [AboutController::class, 'index']);
Route::get('lists', [ListController::class, 'index']);
Route::get('services', [ServiceController::class, 'index']);
Route::get('contacts', [ContactController::class, 'index']);
Route::get('payment', [PaymentController::class, 'index']);
Route::get('sociallinks', [SocialLinkController::class, 'index']);
Route::get('messages', [MessageController::class, 'index']);
Route::get('projects', [ProjectController::class, 'index']);

Route::get('property/{id}', [PropertyController::class, 'single']);
Route::get('category/{id}', [CategoryController::class, 'single']);
Route::get('categoryproperty/{id}', [PropertyController::class, 'category']);
Route::get('blogcategory/{id}', [BlogCategoryController::class, 'single']);
Route::get('blog/{id}', [BlogController::class, 'single']);
Route::get('user/{id}', [UserController::class, 'single']);
Route::get('role/{id}', [RoleController::class, 'single']);
Route::get('condition/{id}', [ConditionController::class, 'single']);
Route::get('furnishing/{id}', [FurnishingController::class, 'single']);
Route::get('location/{id}', [LocationController::class, 'single']);
Route::get('propertytype/{id}', [PropertyTypeController::class, 'single']);
Route::get('about/{id}', [AboutController::class, 'single']);
Route::get('service/{id}', [ServiceController::class, 'single']);
Route::get('contact/{id}', [ContactController::class, 'single']);
Route::get('payment/{id}', [PaymentController::class, 'single']);
Route::get('sociallink/{id}', [SocialLinkController::class, 'single']);
Route::get('message/{id}', [MessageController::class, 'single']);
Route::get('project/{id}', [ProjectController::class, 'single']);
Route::get('landlord/{id}', [LandlordController::class, 'single']);
Route::get('pmsproperty/{id}', [PmsPropertyController::class, 'single']);
Route::get('pmsunits/{id}', [PmsUnitController::class, 'units']);
Route::get('pmsvacantunits/{id}', [PmsUnitController::class, 'vacantUnits']);
Route::get('pmsunit/{id}', [PmsUnitController::class, 'single']);
Route::get('pmstenant/{id}', [PmsTenantController::class, 'single']);
Route::get('pmsexpense/{id}', [PmsExpenseController::class, 'single']);
Route::get('pmsstatement/{id}', [PmsStatementController::class, 'single']);
Route::get('pmsinvoicethrostatement/{id}', [PmsStatementController::class, 'singleInvoice']);
Route::get('pmsinvoicedatethrostatement/{id}', [PmsStatementController::class, 'invoiceDate']);
Route::get('landlordproperty/{id}', [LandlordController::class, 'landlordProperty']);

//property statements
Route::get('pmspropertystatements/{id}', [PmsStatementController::class, 'propertyStatements']);
Route::get('pmslastmonthpropertystatements/{id}', [PmsStatementController::class, 'propertyLastMonthStatements']);
Route::get('pmslastninetypropertystatements/{id}', [PmsStatementController::class, 'propertyLastNinetyStatements']);
Route::get('pmsyearpropertystatements/{id}', [PmsStatementController::class, 'propertyYearStatements']);
Route::get('pmsquarterpropertystatements/{id}', [PmsStatementController::class, 'propertyQuarterStatements']);
Route::get('pmslastyearpropertystatements/{id}', [PmsStatementController::class, 'propertyLastYearStatements']);

Route::get('pmsallpropertystatements/{id}', [PmsStatementController::class, 'propertyAllStatements']);
Route::get('pmspropertyexpenses/{id}', [PmsExpenseController::class, 'propertyExpenses']);
Route::get('pmslastmonthpropertyexpenses/{id}', [PmsExpenseController::class, 'propertyLastMonthExpenses']);
Route::get('pmslastninetypropertyexpenses/{id}', [PmsExpenseController::class, 'propertyLastNinetyExpenses']);
Route::get('pmsyearpropertyexpenses/{id}', [PmsExpenseController::class, 'propertyYearExpenses']);
Route::get('pmsquarterpropertyexpenses/{id}', [PmsExpenseController::class, 'propertyQuarterExpenses']);
Route::get('pmslastyearpropertyexpenses/{id}', [PmsExpenseController::class, 'propertyLastYearExpenses']);
Route::get('pmsallpropertyexpenses/{id}', [PmsExpenseController::class, 'propertyAllExpenses']);

//landlord statements
Route::get('pmslandlordstatements/{id}', [PmsStatementController::class, 'landlordStatements']);


//tenant statements
Route::get('pmstenantstatements/{id}', [PmsStatementController::class, 'tenantStatements']);
Route::get('pmslastmonthtenantstatements/{id}', [PmsStatementController::class, 'tenantLastMonthStatements']);
Route::get('pmslastninetytenantstatements/{id}', [PmsStatementController::class, 'tenantLastNinetyStatements']);
Route::get('pmsyeartenantstatements/{id}', [PmsStatementController::class, 'tenantYearStatements']);
Route::get('pmsquartertenantstatements/{id}', [PmsStatementController::class, 'tenantQuarterStatements']);
Route::get('pmslastyeartenantstatements/{id}', [PmsStatementController::class, 'tenantLastYearStatements']);
Route::get('pmsalltenantstatements/{id}', [PmsStatementController::class, 'tenantAllStatements']);

//tenant invoices
Route::get('pmstenantinvoices/{id}', [PmsInvoiceController::class, 'tenantInvoices']);

//property invoices
Route::get('propertyawaitinginvoicing/{id}', [PmsInvoiceController::class, 'propAwaitingInvoicing']);
Route::get('propertyinvoicestosettle/{id}', [PmsInvoiceController::class, 'propInvoicestoSettle']);

Route::get('propertysettledinvoices/{id}', [PmsInvoiceController::class, 'propSettledInvoices']);
Route::get('propertylastmonthsettledinvoices/{id}', [PmsInvoiceController::class, 'propLastMonthSettledInvoices']);
Route::get('propertylastninetysettledinvoices/{id}', [PmsInvoiceController::class, 'propLastNinetySettledInvoices']);
Route::get('propertyyearsettledinvoices/{id}', [PmsInvoiceController::class, 'propYearSettledInvoices']);
Route::get('propertyquartersettledinvoices/{id}', [PmsInvoiceController::class, 'propQuarterSettledInvoices']);
Route::get('propertylastyearsettledinvoices/{id}', [PmsInvoiceController::class, 'propLastYearSettledInvoices']);
Route::get('propertyallsettledinvoices/{id}', [PmsInvoiceController::class, 'propAllSettledInvoices']);

//get receipts
Route::get('whatsappreceipts/{id}', [ReceiptController::class, 'whatsappReceipts']);
Route::get('emailreceipts/{id}', [ReceiptController::class, 'emailReceipts']);
//delete receipts
Route::delete('/delete-whatsapp-receipt/{id}', [ReceiptController::class, 'deleteWhatsappReceipt']);
Route::delete('/delete-email-receipt/{id}', [ReceiptController::class, 'deleteEmailReceipt']);

//get reminders
Route::get('whatsappreminders/{id}', [ReminderController::class, 'whatsappReminders']);
Route::get('emailreminders/{id}', [ReminderController::class, 'emailReminders']);
//delete reminders
Route::delete('/delete-whatsapp-reminder/{id}', [ReminderController::class, 'deleteWhatsappReminder']);
Route::delete('/delete-email-reminder/{id}', [ReminderController::class, 'deleteEmailReminder']);

Route::put('property/{id}', [PropertyController::class, 'update']);
Route::put('category/{id}', [CategoryController::class, 'update']);
Route::put('blogcategory/{id}', [BlogCategoryController::class, 'update']);
Route::put('blog/{id}', [BlogController::class, 'update']);
Route::put('user/{id}', [UserController::class, 'update']);
Route::put('role/{id}', [RoleController::class, 'update']);
Route::put('condition/{id}', [ConditionController::class, 'update']);
Route::put('furnishing/{id}', [FurnishingController::class, 'update']);
Route::put('location/{id}', [LocationController::class, 'update']);
Route::put('propertytype/{id}', [PropertyTypeController::class, 'update']);
Route::put('about/{id}', [AboutController::class, 'update']);
Route::put('service/{id}', [ServiceController::class, 'update']);
Route::put('contact/{id}', [ContactController::class, 'update']);
Route::put('payment/{id}', [PaymentController::class, 'update']);
Route::put('sociallink/{id}', [SocialLinkController::class, 'update']);
Route::put('message/{id}', [MessageController::class, 'update']);
Route::put('project/{id}', [ProjectController::class, 'update']);
Route::put('landlord/{id}', [LandlordController::class, 'update']);
Route::put('pmsproperty/{id}', [PmsPropertyController::class, 'update']);
Route::put('pmsunit/{id}', [PmsUnitController::class, 'update']);
Route::put('pmstenant/{id}', [PmsTenantController::class, 'update']);
Route::put('pmsexpense/{id}', [PmsExpenseController::class, 'update']);
Route::put('pmsstatement/{id}', [PmsStatementController::class, 'update']);
Route::put('pmssettlestatement/{id}', [PmsStatementController::class, 'settle']);
Route::put('pmsinvoicestatement/{id}', [PmsStatementController::class, 'invoice']);
Route::put('pmslastmonthtenantstatement/{id}', [PmsStatementController::class, 'updateTenantLastMonthStatement']);
Route::put('edit-statement/{id}', [PmsStatementController::class, 'editStatement']);
Route::put('edit-permission/{id}', [ListController::class, 'editPermission']);

Route::delete('property/{id}', [PropertyController::class, 'destroy']);
Route::delete('category/{id}', [CategoryController::class, 'destroy']);
Route::delete('blogcategory/{id}', [BlogCategoryController::class, 'destroy']);
Route::delete('blog/{id}', [BlogController::class, 'destroy']);
Route::delete('user/{id}', [UserController::class, 'destroy']);
Route::delete('role/{id}', [RoleController::class, 'destroy']);
Route::delete('condition/{id}', [ConditionController::class, 'destroy']);
Route::delete('furnishing/{id}', [FurnishingController::class, 'destroy']);
Route::delete('location/{id}', [LocationController::class, 'destroy']);
Route::delete('propertytype/{id}', [PropertyTypeController::class, 'destroy']);
Route::delete('about/{id}', [AboutController::class, 'destroy']);
Route::delete('service/{id}', [ServiceController::class, 'destroy']);
Route::delete('contact/{id}', [ContactController::class, 'destroy']);
Route::delete('payment/{id}', [PaymentController::class, 'destroy']);
Route::delete('sociallink/{id}', [SocialLinkController::class, 'destroy']);
Route::delete('message/{id}', [MessageController::class, 'destroy']);
Route::delete('project/{id}', [ProjectController::class, 'destroy']);
Route::delete('landlord/{id}', [LandlordController::class, 'destroy']);
Route::delete('pmsproperty/{id}', [PmsPropertyController::class, 'destroy']);
Route::delete('pmstenant/{id}', [PmsTenantController::class, 'destroy']);
Route::delete('pmsunit/{id}', [PmsUnitController::class, 'destroy']);
Route::delete('pmsexpense/{id}', [PmsExpenseController::class, 'destroy']);
Route::delete('pmsstatement/{id}', [PmsStatementController::class, 'destroy']);

Route::put('vacatetenant/{id}',[PmsTenantController::class,'vacate']);
Route::put('vacateunit/{id}',[PmsUnitController::class,'vacate']);


Route::put('approveproperty/{id}',[PropertyController::class,'approve']);
Route::put('featureproperty/{id}',[PropertyController::class,'feature']);
Route::put('unfeatureproperty/{id}',[PropertyController::class,'unfeature']);
Route::put('closeproperty/{id}',[PropertyController::class,'close']);
Route::put('reopenproperty/{id}',[PropertyController::class,'reopen']);

Route::put('approveblog/{id}',[BlogController::class,'approve']);
Route::put('featureblog/{id}',[BlogController::class,'feature']);
Route::put('unfeatureblog/{id}',[BlogController::class,'unfeature']);
Route::put('archiveblog/{id}',[BlogController::class,'close']);
Route::put('unarchiveblog/{id}',[BlogController::class,'reopen']);

Route::put('completeproject/{id}',[ProjectController::class,'complete']);
Route::put('featureproject/{id}',[ProjectController::class,'feature']);
Route::put('unfeatureproject/{id}',[ProjectController::class,'unfeature']);
Route::put('closeproject/{id}',[ProjectController::class,'close']);
Route::put('reopenproject/{id}',[ProjectController::class,'reopen']);


Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('user', [AuthController::class, 'userProfile'])->name('userProfile');

Route::post('search', [SearchController::class, 'search'])->name('search');

Route::put('activatesocial/{id}',[SocialLinkController::class,'activate']);
Route::put('deactivatesocial/{id}',[SocialLinkController::class,'deactivate']);

Route::get('myproperties/{id}', [PropertyController::class,'myProperty']);
Route::put('profile/{id}',[ProfileController::class, 'update']);
Route::put('changepassword/{id}',[ProfileController::class, 'changePassword']);
Route::put('/resetpassword',[ProfileController::class, 'resetPassword']);

Route::put('activateuser/{id}',[UserController::class,'activate']);
Route::put('deactivateuser/{id}',[UserController::class,'deactivate']);

Route::post('/posts/media/upload', [PropertyController::class, 'storePropertyPic'])->name('posts.media.upload');

//send sms
Route::post('sendsms', [SearchController::class, 'sendSms'])->name('sendsms');
Route::post('sendtenantsms', [SearchController::class, 'sendTenantSms'])->name('sendTenantsms');
Route::post('sendlandlordsms', [SearchController::class, 'sendLandlordSms'])->name('sendLandlordsms');

//send mail
Route::post('/send-landlordinvoice', [PmsInvoiceController::class, 'sendLandlordInvoice']);
Route::post('/send-tenantinvoice', [PmsInvoiceController::class, 'sendTenantInvoice']);
Route::post('/send-custom-mail', [PmsInvoiceController::class, 'sendCustomMail']);

//update reminder counts
Route::post('/update-email-count', [PmsStatementController::class, 'updateEmailCount']);
Route::post('/update-whatsapp-count', [PmsStatementController::class, 'updateWhatsappCount']);
Route::post('/update-sms-count', [PmsStatementController::class, 'updateSmsCount']);

Route::post('/update-email-receipt-count', [PmsStatementController::class, 'updateEmailReceiptCount']);
Route::post('/update-whatsapp-receipt-count', [PmsStatementController::class, 'updateWhatsappReceiptCount']);


//generate invoices
Route::post('/generate-monthly-statements', [PmsStatementController::class, 'generateMonthlyStatements']);

//user permissions
Route::get('/userpermissions/{id}', [UserController::class, 'userPermissions']);
Route::post('/update-permissions/{id}', [UserController::class, 'updateUserPermissions']);
Route::post('/generate-permissions/{id}', [UserController::class, 'generateUserPermissions']);
Route::delete('permission/{id}', [ListController::class, 'destroy']);
Route::post('/save-permission', [ListController::class, 'savePermission']);
