<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\CommonController;
use App\Http\Controllers\admin\CMSController;
use App\Http\Controllers\admin\ReviewController;
use App\Http\Controllers\admin\ContentController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\AboutController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\ConstructionTypeController;
use App\Http\Controllers\admin\ContractorTradeController;
use App\Http\Controllers\admin\FAQController;
use App\Http\Controllers\admin\FeedbackController;
use App\Http\Controllers\admin\HowItWorkController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\ProjectCateoryController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\RolePermissionController;
use App\Http\Controllers\admin\StatesController;
use App\Http\Controllers\admin\SubCateoryController;
use App\Http\Controllers\admin\TestiMonialWorkController;

#Admin routes
Route::get('/login', function () {
    return redirect()->route('admin.dashboard');
});
Route::match(['GET', 'POST'], '/', [AuthController::class, 'login'])->name('login');
Route::match(['GET', 'POST'], 'forgot-password', [AuthController::class, 'forgotpassword'])->name('forgot.password');
Route::match(['GET', 'POST'], 'registration', [AuthController::class, 'registration'])->name('register');
Route::match(['GET', 'POST'], 'post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::match(['GET', 'POST'], 'password-recovery/{rowid?}', [AuthController::class, 'passwordrecovery'])->name('password.recovery');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::match(['GET', 'POST'], 'refresh_captcha', [AuthController::class, "refreshCaptcha"])->name('refresh_captcha');


// Route::middleware(['auth', 'roleif:admin'])->group(function () {
Route::middleware(['auth'])->group(function () {
    Route::match(['GET', 'POST'], 'dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::match(['GET', 'POST'], 'profilesetup', [DashboardController::class, 'profilesetup'])->name('profilesetup');

    #roles
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::match(['GET', 'POST'], 'list', [RoleController::class, 'index'])->name('list');
        Route::match(['GET', 'POST'], '/role-create', [RoleController::class, "create"])->name('role-create');
        Route::match(['GET', 'POST'], '/role-store', [RoleController::class, 'store'])->name('role-store');
        Route::match(['GET', 'POST'], '/role-edit/{id}', [RoleController::class, "edit"])->name('role-edit');
        Route::delete('/role-delete/{id}', [RoleController::class, 'destroy'])->name('role-delete');
    });

    #permissions
    //  Route::resource('permission', PermissionController::class);
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::match(['GET', 'POST'], 'list', [PermissionController::class, 'index'])->name('list');
        Route::match(['GET', 'POST'], '/permission-create', [PermissionController::class, "create"])->name('permission-create');
        Route::match(['GET', 'POST'], '/permission-store', [PermissionController::class, 'store'])->name('permission-store');
        Route::match(['GET', 'POST'], '/permission-edit/{id}', [PermissionController::class, "edit"])->name('permission-edit');
        // Route::delete('/permission-delete/{id}', [PermissionController::class, 'destroy'])->name('permission-delete');
        Route::match(['GET', 'POST'], '/delete', [PermissionController::class, 'destroy'])->name('delete');
    });

    #role-permissions
    Route::prefix('role-permissions')->name('role-permissions.')->group(function () {
        Route::match(['GET', 'POST'], 'list', [RolePermissionController::class, 'index'])->name('list');
        Route::match(['GET', 'POST'], '/create', [RolePermissionController::class, "create"])->name('create');
        Route::match(['GET', 'POST'], '/store', [RolePermissionController::class, 'store'])->name('store');
        Route::match(['GET', 'POST'], '/edit/{id}', [RolePermissionController::class, "edit"])->name('edit');
        Route::put('/update/{id}', [RolePermissionController::class, "update"])->name('update');
        Route::delete('/delete/{id}', [RolePermissionController::class, 'destroy'])->name('delete');
    });


    #subcategory
    Route::prefix('subcategory')->name('subcategory.')->group(function () {
        Route::match(['GET', 'POST'], 'list', [SubCateoryController::class, 'index'])->name('list');
        Route::match(['GET', 'POST'], '/create', [SubCateoryController::class, "create"])->name('create');
        Route::match(['GET', 'POST'], '/store', [SubCateoryController::class, 'store'])->name('store');
        Route::match(['GET', 'POST'], '/edit/{id}', [SubCateoryController::class, "edit"])->name('edit');
        Route::match(['GET', 'POST'], '/update/{id}', [SubCateoryController::class, "update"])->name('update');
        Route::delete('/delete/{id}', [SubCateoryController::class, 'destroy'])->name('delete');
    });

    #banner
    Route::prefix('banner')->name('banner.')->group(function () {
        Route::match(['GET', 'POST'], 'banner-page', [BannerController::class, 'index'])->name('banner');
        Route::match(['GET', 'POST'], '/banner-create', [BannerController::class, "create"])->name('banner-create');
        Route::match(['GET', 'POST'], '/banner-store', [BannerController::class, 'store'])->name('banner-store');
        Route::match(['GET', 'POST'], '/banner-edit/{id}', [BannerController::class, 'editBanner'])->name('banner-edit');
        Route::match(['GET', 'POST'], '/banner-update', [BannerController::class, 'BannerUpdate'])->name('banner-update');

        Route::match(['GET', 'POST'], '/delete', [BannerController::class, 'deletebanner'])->name('delete');
        // Route::match(['GET', 'POST'], 'banner-get/{rowid?}', [BannerController::class, 'getsinglerow'])->name('banner.get');
    });

    #CMS Pages
    Route::prefix('cms')->name('cms.')->group(function () {
        #pages
        Route::prefix('pages')->name('pages.')->group(function () {
            Route::match(['GET', 'POST'], '/list', [PageController::class, 'index'])->name('list');
            Route::match(['GET', 'POST'], '/create', [PageController::class, 'create'])->name('create');
            Route::match(['GET', 'POST'], '/store', [PageController::class, 'store'])->name('store');
            Route::match(['GET', 'POST'], '/edit/{id}', [PageController::class, 'edit'])->name('edit');
            Route::match(['GET', 'POST'], '/update', [PageController::class, 'update'])->name('update');
            Route::match(['GET', 'POST'], '/delete', [PageController::class, 'delete'])->name('delete');
        });
        Route::prefix('how_it_work')->name('how_it_work.')->group(function () {
            Route::match(['GET', 'POST'], '/list', [HowItWorkController::class, 'index'])->name('list');
            Route::match(['GET', 'POST'], '/create', [HowItWorkController::class, 'create'])->name('create');
            Route::match(['GET', 'POST'], '/store', [HowItWorkController::class, 'store'])->name('store');
            Route::match(['GET', 'POST'], '/edit/{id}', [HowItWorkController::class, 'edit'])->name('edit');
            Route::match(['GET', 'POST'], '/update', [HowItWorkController::class, 'update'])->name('update');
            Route::match(['GET', 'POST'], '/delete', [HowItWorkController::class, 'delete'])->name('delete');
        });

        Route::prefix('testimonial')->name('testimonial.')->group(function () {
            Route::match(['GET', 'POST'], '/list', [TestiMonialWorkController::class, 'index'])->name('list');
            Route::match(['GET', 'POST'], '/create', [TestiMonialWorkController::class, 'create'])->name('create');
            Route::match(['GET', 'POST'], '/store', [TestiMonialWorkController::class, 'store'])->name('store');
            Route::match(['GET', 'POST'], '/edit/{id}', [TestiMonialWorkController::class, 'edit'])->name('edit');
            Route::match(['GET', 'POST'], '/update', [TestiMonialWorkController::class, 'update'])->name('update');
            Route::match(['GET', 'POST'], '/delete', [TestiMonialWorkController::class, 'delete'])->name('delete');
        });

        Route::prefix('blog')->name('blog.')->group(function () {
            Route::match(['GET', 'POST'], '/list', [BlogController::class, 'index'])->name('list');
            Route::match(['GET', 'POST'], '/create', [BlogController::class, 'create'])->name('create');
            Route::match(['GET', 'POST'], '/store', [BlogController::class, 'store'])->name('store');
            Route::match(['GET', 'POST'], '/edit/{id}', [BlogController::class, 'edit'])->name('edit');
            Route::match(['GET', 'POST'], '/update', [BlogController::class, 'update'])->name('update');
            Route::match(['GET', 'POST'], '/delete', [BlogController::class, 'delete'])->name('delete');
        });
        Route::prefix('faq')->name('faq.')->group(function () {
            Route::match(['GET', 'POST'], '/list', [FAQController::class, 'index'])->name('list');
            Route::match(['GET', 'POST'], '/create', [FAQController::class, 'create'])->name('create');
            Route::match(['GET', 'POST'], '/store', [FAQController::class, 'store'])->name('store');
            Route::match(['GET', 'POST'], '/edit/{id}', [FAQController::class, 'edit'])->name('edit');
            Route::match(['GET', 'POST'], '/update', [FAQController::class, 'update'])->name('update');
            Route::match(['GET', 'POST'], '/delete', [FAQController::class, 'delete'])->name('delete');
        });

        Route::prefix('feedback')->name('feedback.')->group(function () {
            Route::match(['GET', 'POST'], '/list', [FeedbackController::class, 'index'])->name('list');
            Route::match(['GET', 'POST'], '/create', [FeedbackController::class, 'create'])->name('create');
            Route::match(['GET', 'POST'], '/store', [FeedbackController::class, 'store'])->name('store');
            Route::match(['GET', 'POST'], '/edit/{id}', [FeedbackController::class, 'edit'])->name('edit');
            Route::match(['GET', 'POST'], '/update', [FeedbackController::class, 'update'])->name('update');
            Route::match(['GET', 'POST'], '/delete', [FeedbackController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('contractor')->name('contractor.')->group(function () {
        Route::match(['GET', 'POST'], '/list', [ContractorTradeController::class, 'index'])->name('list');
        Route::match(['GET', 'POST'], '/create', [ContractorTradeController::class, 'create'])->name('create');
        Route::match(['GET', 'POST'], '/store', [ContractorTradeController::class, 'store'])->name('store');
        Route::match(['GET', 'POST'], '/edit/{id}', [ContractorTradeController::class, 'edit'])->name('edit');
        Route::match(['GET', 'POST'], '/update', [ContractorTradeController::class, 'update'])->name('update');
        Route::match(['GET', 'POST'], '/delete', [ContractorTradeController::class, 'delete'])->name('delete');
    });

    Route::prefix('constructor-type')->name('constructor-type.')->group(function () {
        Route::match(['GET', 'POST'], '/list', [ConstructionTypeController::class, 'index'])->name('list');
        Route::match(['GET', 'POST'], '/create', [ConstructionTypeController::class, 'create'])->name('create');
        Route::match(['GET', 'POST'], '/store', [ConstructionTypeController::class, 'store'])->name('store');
        Route::match(['GET', 'POST'], '/edit/{id}', [ConstructionTypeController::class, 'edit'])->name('edit');
        Route::match(['GET', 'POST'], '/update', [ConstructionTypeController::class, 'update'])->name('update');
        Route::match(['GET', 'POST'], '/delete', [ConstructionTypeController::class, 'delete'])->name('delete');
    });

    Route::prefix('states')->name('states.')->group(function () {
        Route::match(['GET', 'POST'], '/list', [StatesController::class, 'index'])->name('list');
        Route::match(['GET', 'POST'], '/create', [StatesController::class, 'create'])->name('create');
        Route::match(['GET', 'POST'], '/store', [StatesController::class, 'store'])->name('store');
        Route::match(['GET', 'POST'], '/edit/{id}', [StatesController::class, 'edit'])->name('edit');
        Route::match(['GET', 'POST'], '/update', [StatesController::class, 'update'])->name('update');
        Route::match(['GET', 'POST'], '/delete', [StatesController::class, 'delete'])->name('delete');
    });

    #Review
    Route::match(['GET', 'POST'], 'review', [ReviewController::class, 'index'])->name('review');
    Route::get('review-get/{rowid?}', [ReviewController::class, 'getsinglerow'])->name('review.get');



    #projects
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::match(['GET', 'POST'], 'project-category-get/{rowid?}', [ProjectController::class, 'getsingleCategoryrow'])->name('project-category-get');
        Route::match(['GET', 'POST'], '/project', [ProjectController::class, "index"])->name('project');
        Route::match(['GET', 'POST'], '/project-create', [ProjectController::class, "create"])->name('project-create');
        Route::match(['GET', 'POST'], '/project-store', [ProjectController::class, 'store'])->name('project-store');
        Route::match(['GET', 'POST'], '/project-edit/{id}', [ProjectController::class, 'edit'])->name('project-edit');
        Route::match(['GET', 'POST'], '/project-update', [ProjectController::class, 'ProjectUpdate'])->name('project-update');
        Route::match(['GET', 'POST'], '/delete', [ProjectController::class, 'delete'])->name('delete');
    });

    #projects-category
    Route::prefix('project-category')->name('project-category.')->group(function () {
        Route::match(['GET', 'POST'], '/list', [ProjectCateoryController::class, 'index'])->name('list');
        Route::match(['GET', 'POST'], '/create', [ProjectCateoryController::class, 'create'])->name('create');
        Route::match(['GET', 'POST'], '/store', [ProjectCateoryController::class, 'store'])->name('store');
        Route::match(['GET', 'POST'], '/edit/{id}', [ProjectCateoryController::class, 'editcategory'])->name('edit');
        Route::match(['GET', 'POST'], '/update', [ProjectCateoryController::class, 'updatecategory'])->name('update');
        Route::match(['GET', 'POST'], '/delete', [ProjectCateoryController::class, 'delete'])->name('delete');
    });

    Route::prefix('content')->name('content.')->group(function () {
        Route::match(['GET', 'POST'], '/list', [ContentController::class, 'index'])->name('list');
        Route::match(['GET', 'POST'], '/create', [ContentController::class, 'create'])->name('content_create');
        Route::match(['GET', 'POST'], '/store', [ContentController::class, 'store'])->name('content_store');
        Route::match(['GET', 'POST'], '/editContent/{id}', [ContentController::class, 'editContent'])->name('editContent');
        Route::match(['GET', 'POST'], '/content_update', [ContentController::class, 'content_update'])->name('content_update');
        Route::match(['GET', 'POST'], '/delete', [ContentController::class, 'delete'])->name('delete');
    });


    Route::prefix('users')->name('users.')->group(function () {
        Route::match(['GET', 'POST'], '/list', [CustomerController::class, 'index'])->name('list');
        Route::match(['GET', 'POST'], '/user-create', [CustomerController::class, 'create'])->name('user-create');
        Route::match(['GET', 'POST'], '/store', [CustomerController::class, 'store'])->name('user-store');
        Route::match(['GET', 'POST'], '/user-edit/{id}', [CustomerController::class, 'editUser'])->name('user-edit');
        Route::match(['GET', 'POST'], '/update-user', [CustomerController::class, 'updateUser'])->name('update-user');
        Route::match(['GET', 'POST'], '/delete-user', [CustomerController::class, 'delete'])->name('delete-user');
    });

    Route::prefix('about')->name('about.')->group(function () {
        Route::match(['GET', 'POST'], '/list', [AboutController::class, 'index'])->name('list');
        Route::match(['GET', 'POST'], '/about.create', [AboutController::class, 'create'])->name('about.create');
        Route::match(['GET', 'POST'], '/about-store', [AboutController::class, 'store'])->name('about-store');
        Route::match(['GET', 'POST'], '/edit-about/{id}', [AboutController::class, 'editAbout'])->name('edit-about');
        Route::match(['GET', 'POST'], '/edit-about/{id}', [AboutController::class, 'editAbout'])->name('edit-about');
        Route::match(['GET', 'POST'], '/about-update', [AboutController::class, 'about_update'])->name('about-update');
    });

    Route::match(['GET', 'POST'], 'setting', [SettingController::class, 'index'])->name('setting');
    Route::match(['GET', 'POST'], 'site_info', [SettingController::class, 'site_info'])->name('site_info');
    Route::match(['GET', 'POST'], 'meta_info', [SettingController::class, 'meta_info'])->name('meta_info');
    Route::match(['GET', 'POST'], 'smtp_info', [SettingController::class, 'smtp_info'])->name('smtp_info');

    #status change
    Route::post('{type?}/status-change', [CommonController::class, 'statuschange'])->name('status.change');
    Route::post('{type?}/delete_status', [CommonController::class, 'delete_status'])->name('delete_status');
    Route::post('{type?}/delete_data', [CommonController::class, 'delete_data'])->name('delete_data');
});
