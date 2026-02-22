<?php

use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\CobitItemController;
use App\Http\Controllers\QuisionerController;
use App\Http\Controllers\UserProgressController;
use App\Http\Controllers\Admin\ProgressController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ResubmissionRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminPaymentController;

// ================= MAIN ROUTES ====================


Route::get('/', function () {
    return view('auth/login');
});

Route::get('/menunggu-persetujuan', [PageController::class, 'pending'])
    ->name('registration.pending');

// Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});

// User profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




// ================= ADMIN ROUTES ====================

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('admin/progress', [ProgressController::class, 'index'])
        ->name('admin.progress.index');
    Route::get('/admin/progress/{user}/pdf', 
        [ProgressController::class, 'downloadPDF'])
        ->name('admin.progress.downloadPDF');

    Route::get('/progress/{user}', [ProgressController::class, 'show'])
        ->name('admin.progress.show');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Report
    Route::get('/admin/report', [\App\Http\Controllers\Admin\ReportController::class, 'index'])
        ->name('admin.report.index');
    Route::get('/admin/report/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])
        ->name('admin.report.export');

    // Approvals
    Route::get('/approvals', [UserApprovalController::class, 'index'])
        ->name('admin.approvals.index');
    Route::post('/approvals/{user}', [UserApprovalController::class, 'approve'])
        ->name('admin.approvals.approve');
    Route::post('/approvals/{user}/reject', [UserApprovalController::class, 'reject'])
        ->name('admin.approvals.reject');

    // Users CRUD
    Route::resource('users', UserController::class);

    // Cobit Item CRUD
    Route::resource('cobititem', CobitItemController::class);

    // Kategori, Level, Quisioner
    Route::resource('kategori', KategoriController::class);
    Route::resource('level', LevelController::class);
    Route::resource('quisioner', QuisionerController::class);

    // Resubmission (Admin)
    Route::get('/resubmission-requests', [ResubmissionRequestController::class, 'adminIndex'])
        ->name('resubmissions.index');
    Route::post('/resubmission-requests/{resubmissionRequest}/approve', 
        [ResubmissionRequestController::class, 'approve'])
        ->name('resubmissions.approve');
    Route::post('/resubmission-requests/{resubmissionRequest}/reject', 
        [ResubmissionRequestController::class, 'reject'])
        ->name('resubmissions.reject');

    // Excel
    Route::post('/import', [ExcelController::class,'import'])->name('excel.import');
    Route::get('/import', [ExcelController::class,'index'])->name('excel.index');

    // Payment Admin
    Route::get('/payments', [AdminPaymentController::class, 'index'])
        ->name('admin.payments.index');
    Route::get('/payments/{transaction}', [AdminPaymentController::class, 'show'])
        ->name('admin.payments.show');
    Route::patch('/payments/{transaction}', [AdminPaymentController::class, 'verify'])
        ->name('admin.payments.verify');

    // Admin Profile
    Route::get('/profileadmin', [AdminProfileController::class, 'edit'])
        ->name('profileadmin.edit');
    Route::patch('/profileadmin', [AdminProfileController::class, 'update'])
        ->name('profileadmin.update');

    // Admin Assessments Managed via new AdminAssessmentController
    Route::resource('admin/assessments', \App\Http\Controllers\Admin\AdminAssessmentController::class, [
        'names' => 'admin.assessments'
    ]);
    Route::post('/admin/assessments/{assessment}/approve', [\App\Http\Controllers\Admin\AdminAssessmentController::class, 'approve'])
        ->name('admin.assessments.approve');
    Route::post('/admin/assessments/{assessment}/reject', [\App\Http\Controllers\Admin\AdminAssessmentController::class, 'reject'])
        ->name('admin.assessments.reject');
    Route::get('/admin/transactions/{transaction}/eligible-items', [\App\Http\Controllers\Admin\AdminAssessmentController::class, 'getEligibleItems'])
        ->name('admin.transactions.eligible-items');

    // Coupon Management
    Route::resource('coupons', AdminCouponController::class)->names('admin.coupons');
    Route::patch('coupons/{coupon}/toggle', [AdminCouponController::class, 'toggleStatus'])
        ->name('admin.coupons.toggle');

});


// ================= USER ROUTES ====================

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Design Factor (DF1, DF2, etc.)
    Route::get('/design-factors/{type?}', [\App\Http\Controllers\DesignFactorController::class, 'index'])
        ->name('design-factors.index');
    Route::get('/design-factors-summary', [\App\Http\Controllers\DesignFactorController::class, 'summary'])
        ->name('design-factors.summary');
    Route::get('/design-factors-summary-df510', [\App\Http\Controllers\DesignFactorController::class, 'summaryDf510'])
        ->name('design-factors.summary-df510');
    Route::post('/design-factors', [\App\Http\Controllers\DesignFactorController::class, 'store'])
        ->name('design-factors.store');
    Route::post('/design-factors/lock-summary', [\App\Http\Controllers\DesignFactorController::class, 'lockSummary'])
        ->name('design-factors.lock-summary');
    Route::post('/design-factors/calculate', [\App\Http\Controllers\DesignFactorController::class, 'calculate'])
        ->name('design-factors.calculate');
    Route::post('/design-factors/reset-all', [\App\Http\Controllers\DesignFactorController::class, 'resetAll'])
        ->name('design-factors.reset-all');
    Route::delete('/design-factors/item/{item}', [\App\Http\Controllers\DesignFactorController::class, 'deleteItem'])
        ->name('design-factors.delete-item');

    // DF5 Routes
    Route::post('/design-factors-df5/calculate', [\App\Http\Controllers\DesignFactorController::class, 'calculateDf5'])
        ->name('design-factors.df5.calculate');

    // DF6 Routes
    Route::post('/design-factors-df6/calculate', [\App\Http\Controllers\DesignFactorController::class, 'calculateDf6'])
        ->name('design-factors.df6.calculate');

    // DF8 Routes
    Route::post('/design-factors-df8/calculate', [\App\Http\Controllers\DesignFactorController::class, 'calculateDf8'])
        ->name('design-factors.df8.calculate');

    // DF9 Routes
    Route::post('/design-factors-df9/calculate', [\App\Http\Controllers\DesignFactorController::class, 'calculateDf9'])
        ->name('design-factors.df9.calculate');

    // DF10 Routes
    Route::post('/design-factors-df10/calculate', [\App\Http\Controllers\DesignFactorController::class, 'calculateDf10'])
        ->name('design-factors.df10.calculate');





    // ================= PAYMENT ROUTES (USER) ================
    // Pricing
    Route::get('/pricing', [PaymentController::class, 'index'])
        ->name('pricing.index');

    // Checkout halaman
    Route::get('/checkout/{package}', [PaymentController::class, 'checkout'])
        ->name('payment.checkout');

    // PAY → Midtrans Snap Redirect
    Route::post('/pay/{id}', [PaymentController::class, 'pay'])
        ->name('payment.pay');

    // History transaksi user
    Route::get('/payment/history', [PaymentController::class, 'history'])
        ->name('payment.history');

    // Detail transaksi
    Route::get('/payment/{transaction}', [PaymentController::class, 'show'])
        ->name('payment.show');

    // MIDTRANS CALLBACK
    Route::post('/midtrans/callback', [PaymentController::class, 'callback'])
        ->name('midtrans.callback');

    // Apply Coupon
    Route::post('/payment/{transaction}/apply-coupon', [PaymentController::class, 'applyCoupon'])
        ->name('payment.apply-coupon');

    // ========================================================


    // Audit (protected by check.subscription)
    Route::middleware(['check.subscription'])->group(function() {
         Route::get('/audit/{assessment}', [AuditController::class, 'index'])->name('audit.index');
         Route::get('/audit/{assessment}/{cobitItem}', [AuditController::class, 'showCategories'])->name('audit.showCategories');
         Route::get('/audit/{assessment}/{cobitItem}/{kategori}', [AuditController::class, 'showLevels'])->name('audit.showLevels');
         Route::get('/audit/{assessment}/{cobitItem}/{kategori}/{level}', [AuditController::class, 'showQuisioner'])->name('audit.showQuisioner');
         Route::post('/audit/{assessment}/{level}/jawaban', [JawabanController::class, 'store'])->name('jawaban.store');
         Route::post('/audit/{assessment}/{level}/draft', [JawabanController::class, 'saveDraft'])->name('jawaban.saveDraft');
         Route::post('/audit/{assessment}/levels/{level}/request-resubmission', [ResubmissionRequestController::class, 'store'])->name('resubmission.request');
    });

    // User Progress
    Route::get('/progress', [UserProgressController::class, 'index'])
        ->name('user.progress.index');
    Route::get('/my-progress', [UserProgressController::class, 'downloadPDF'])
        ->name('user.progress.download');

    // User Assessments
    Route::get('/my-assessments', [\App\Http\Controllers\UserAssessmentController::class, 'index'])
        ->name('user.assessments.index');
    Route::get('/my-assessments/{assessment}', [\App\Http\Controllers\UserAssessmentController::class, 'show'])
        ->name('user.assessments.show');
    Route::post('/my-assessments/{assessment}/submit', [\App\Http\Controllers\UserAssessmentController::class, 'submit'])
        ->name('user.assessments.submit');
    Route::post('/my-assessments/{assessment}/start', [\App\Http\Controllers\UserAssessmentController::class, 'start'])
        ->name('user.assessments.start');
    Route::post('/my-assessments/{assessment}/complete', [\App\Http\Controllers\UserAssessmentController::class, 'complete'])
        ->name('user.assessments.complete');

    // User view final audit report
    Route::get('/my-assessments/{assessment}/report', [\App\Http\Controllers\AuditReportController::class, 'showForUser'])
        ->name('user.assessments.report');
});



// ================= AUDITOR ROUTES ====================

Route::middleware(['auth', 'role:auditor'])->group(function () {
    Route::get('/auditor/dashboard', [\App\Http\Controllers\AuditorController::class, 'index'])
        ->name('auditor.dashboard');
    Route::get('/auditor/assessments/{assessment}', [\App\Http\Controllers\AuditorController::class, 'show'])
        ->name('auditor.assessments.show');
    Route::post('/auditor/jawaban/{jawaban}/verify', [\App\Http\Controllers\AuditorController::class, 'verify'])
        ->name('auditor.verify');
    Route::post('/auditor/assessments/{assessment}/bulk-verify', [\App\Http\Controllers\AuditorController::class, 'bulkVerify'])
        ->name('auditor.bulk-verify');
    Route::post('/auditor/assessments/{assessment}/complete', [\App\Http\Controllers\AuditorController::class, 'markComplete'])
        ->name('auditor.complete');
    Route::get('/auditor/evidence/{jawaban}', [\App\Http\Controllers\AuditorController::class, 'viewEvidence'])
        ->name('auditor.evidence');

    // Audit Report routes
    Route::get('/auditor/assessments/{assessment}/report/create', [\App\Http\Controllers\AuditReportController::class, 'create'])
        ->name('auditor.report.create');
    Route::post('/auditor/assessments/{assessment}/report', [\App\Http\Controllers\AuditReportController::class, 'store'])
        ->name('auditor.report.store');
    Route::get('/auditor/reports/{report}', [\App\Http\Controllers\AuditReportController::class, 'show'])
        ->name('auditor.report.show');
    Route::get('/auditor/reports/{report}/edit', [\App\Http\Controllers\AuditReportController::class, 'edit'])
        ->name('auditor.report.edit');
    Route::put('/auditor/reports/{report}', [\App\Http\Controllers\AuditReportController::class, 'update'])
        ->name('auditor.report.update');
    Route::post('/auditor/reports/{report}/finalize', [\App\Http\Controllers\AuditReportController::class, 'finalize'])
        ->name('auditor.report.finalize');
});

// Audit Report Export Routes (Accessible by both Auditors and Users)
Route::middleware(['auth'])->group(function () {
    Route::get('/reports/{report}/pdf', [\App\Http\Controllers\AuditReportController::class, 'exportPdf'])
        ->name('auditor.report.pdf');
    Route::get('/reports/{report}/excel', [\App\Http\Controllers\AuditReportController::class, 'exportExcel'])
        ->name('auditor.report.excel');
});


// Waiting Approval Page
Route::get('/waiting-approval', function () {
    return view('waiting-approval');
})->name('waiting-approval');


require __DIR__ . '/auth.php';
