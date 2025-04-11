<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\site\HomeController;
use App\Http\Controllers\site\AuthController;
use App\Http\Controllers\site\DocumentController;
use App\Http\Controllers\site\ProjectController;
use App\Http\Controllers\site\ServicesController;


Route::middleware(['common'], ['roleif:user'])->group(function () {
    Route::get('/verify-email/{id}', [AuthController::class, 'verifyEmail'])->name('email.verify');
    Route::match(['GET', 'POST'], 'login', [AuthController::class, "login"])->name('login_user');
    Route::match(['GET', 'POST'], 'Userlogin', [AuthController::class, "Userlogin"])->name('Userlogin');
    Route::match(['GET', 'POST'], 'sign_up', [AuthController::class, 'sign_up'])->name('sign_up');
    Route::match(['GET', 'POST'], 'forgot-password', [AuthController::class, 'forgotpassword'])->name('forgot.password');
    Route::match(['GET', 'POST'], 'password-recovery/{rowid?}', [AuthController::class, 'passwordrecovery'])->name('password.recovery');
    Route::match(['GET', 'POST'], 'profile', [AuthController::class, 'profile'])->name('profile');

    Route::match(['GET', 'POST'], 'post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
    Route::match(['GET', 'POST'], 'sign_up', [AuthController::class, "sign_up"])->name('sign_up');
    Route::match(['GET', 'POST'], 'sign_up', [AuthController::class, "sign_up"])->name('sign_up');
    Route::match(['GET', 'POST'], 'logout', [AuthController::class, "logout"])->name('logout');
    Route::match(['GET', 'POST'], 'refresh_captcha', [AuthController::class, "refreshCaptcha"])->name('refresh_captcha');

    Route::match(['GET', 'POST'], '/', [HomeController::class, 'index'])->name('/');
    Route::match(['GET', 'POST'], 'about-us', [HomeController::class, "AboutUs"])->name('about-us');
    Route::match(['GET', 'POST'], 'brands', [HomeController::class, "Brands"])->name('brands');
    

    Route::match(['GET', 'POST'], 'blog', [HomeController::class, "blog"])->name('blog');
    Route::match(['GET', 'POST'], 'faqs', [HomeController::class, "faq"])->name('faqs');
    Route::match(['GET', 'POST'], 'contact-us', [HomeController::class, "Contactus"])->name('contact-us');
    Route::match(['GET', 'POST'], 'contractors', [HomeController::class, "Contractors"])->name('contractors');
    Route::match(['GET', 'POST'], 'find-project', [HomeController::class, "findProject"])->name('find-project');
    Route::match(['GET', 'POST'], 'account-details', [HomeController::class, "Account_details"])->name('account-details');
    Route::match(['GET', 'POST'], 'change-password', [HomeController::class, "ChangePwd"])->name('change-password');
    Route::match(['GET', 'POST'], 'update-password/{rowid?}', [HomeController::class, "ChangePwdUpdate"])->name('update-password');
    Route::match(['GET', 'POST'], 'account-details-update/{rowid?}', [HomeController::class, "Account_details_update"])->name('account-details-update');
    Route::match(['GET', 'POST'], 'submit-contactform', [HomeController::class, "submitContactForm"])->name('submit-contactform');
    Route::match(['GET', 'POST'], 'business-docs', [HomeController::class, "BusinessDoc"])->name('business-docs');
    Route::match(['GET', 'POST'], 'update.business-docs', [HomeController::class, "UpdateBusinessDoc"])->name('update.business-docs');

    Route::match(['GET', 'POST'], 'page-view-details/{slug?}', [HomeController::class, "PageViewDetails"])->name('page-view-details');
    Route::match(['GET', 'POST'], 'blog-details/{slug?}', [HomeController::class, "GetBlogDetails"])->name('blog-details');
    Route::match(['GET', 'POST'], 'project-details/{slug?}', [HomeController::class, "GetProjectCategoryDetails"])->name('project-details');
    Route::match(['GET', 'POST'], 'news-letter', [HomeController::class, "newsLetter"])->name('news-letter');

    Route::match(['GET', 'POST'], 'other-services', [ServicesController::class, "OtherServices"])->name('other-services');
    Route::match(['GET', 'POST'], 'services/{slug?}', [ServicesController::class, "ServiceDetails"])->name('ServiceDetails');
    Route::match(['GET', 'POST'], 'testimonial', [ServicesController::class, "testimonial"])->name('testimonial');

    Route::match(['GET', 'POST'], 'terms-and-conditation', [HomeController::class, "TermsAndConditation"])->name('terms-and-conditation');
    Route::match(['GET', 'POST'], 'privacy-policy', [HomeController::class, "PrivacyPolicy"])->name('privacy-policy');
    Route::match(['GET', 'POST'], '/documents-create', [DocumentController::class, 'doc_create'])->name('documents.create');
    Route::match(['GET', 'POST'],'/documents-store', [DocumentController::class, 'store'])->name('documents.store');
    Route::match(['GET', 'POST'],'/documents/destroy', [DocumentController::class, 'destroy'])->name('documents.destroy');

    Route::prefix('project')->name('project.')->group(function () {
        Route::match(['GET', 'POST'], 'list', [ProjectController::class, "index"])->name('list');
    });

    
    
});
