<?php

use Illuminate\Support\Facades\Route;

// Pages publiques statiques (ajout Cascade)

// Route fallback pour éviter l'erreur Route [login] not defined
Route::get('/login', function () {
    return redirect('/');
})->name('login');
// Rediriger les anciens liens /about vers la bonne route /a-propos
Route::redirect('/about', '/a-propos', 302);
// Ancienne route commentée pour référence
// Route::view('/demande', 'public.demande')->name('demande_static');
Route::view('/suivi', 'public.suivi')->name('suivi_static');
Route::view('/missions', 'public.missions')->name('missions_static');
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\InstitutionController;
use App\Http\Controllers\Public\NewsController;
use App\Http\Controllers\Public\ReportsController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\ActionController;
use App\Http\Controllers\Public\TrackController;
use App\Http\Controllers\Public\GalleryController;
use App\Http\Controllers\Public\SpeechesController;
use App\Http\Controllers\Public\DemandeController;
use App\Http\Controllers\Public\PartnersController;

// Public Routes - Formulaire de demande
Route::get('/demande', [DemandeController::class, 'create'])->name('demande.create');
Route::post('/demande', [DemandeController::class, 'store'])->name('demande.store');

// Alias pour la compatibilité avec les anciens liens
Route::redirect('/demande-static', '/demande', 301);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [AboutController::class, 'index'])->name('about');
Route::get('/institution', [InstitutionController::class, 'index'])->name('institution');
Route::get('/actualites', [\App\Http\Controllers\Public\NewsController::class, 'index'])->name('news');
Route::get('/actualites/{id}', [\App\Http\Controllers\Public\NewsController::class, 'show'])->name('news.show');
Route::get('/rapports', [ReportsController::class, 'index'])->name('reports');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Action Routes
Route::get('/effectuer-une-action', [ActionController::class, 'index'])->name('action');
Route::post('/effectuer-une-action', [ActionController::class, 'submit'])->name('request.submit');

// Track Routes
Route::get('/suivre-ma-demande', [TrackController::class, 'index'])->name('track');
Route::post('/suivre-ma-demande', [TrackController::class, 'track'])->name('track.request');
Route::get('/suivre-ma-demande/{code}/pdf', [TrackController::class, 'download'])->name('track.download');

// Gallery Routes
Route::get('/missions-en-images', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// Public Partners
Route::get('/partenaires', [PartnersController::class, 'index'])->name('partners.index');

// Speeches Routes
Route::get('/discours', [SpeechesController::class, 'index'])->name('speeches');
Route::get('/discours/{id}', [SpeechesController::class, 'show'])->name('speech');

// Newsletter
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

// Success page for request submission
Route::get('/demande-succes', [HomeController::class, 'requestSuccess'])->name('request.success');

// SIM Reports Routes
Route::get('/sim', [\App\Http\Controllers\Public\SimController::class, 'index'])->name('sim.index');
Route::get('/sim/dashboard', [\App\Http\Controllers\Public\SimController::class, 'dashboard'])->name('sim.dashboard');
Route::get('/sim/prices', [\App\Http\Controllers\Public\SimController::class, 'prices'])->name('sim.prices');
Route::get('/sim/supply', [\App\Http\Controllers\Public\SimController::class, 'supply'])->name('sim.supply');
Route::get('/sim/regional', [\App\Http\Controllers\Public\SimController::class, 'regional'])->name('sim.regional');
Route::get('/sim/distributions', [\App\Http\Controllers\Public\SimController::class, 'distributions'])->name('sim.distributions');
Route::get('/sim/magasins', [\App\Http\Controllers\Public\SimController::class, 'magasins'])->name('sim.magasins');
Route::get('/sim/operations', [\App\Http\Controllers\Public\SimController::class, 'operations'])->name('sim.operations');
Route::get('/sim/{simReport}', [\App\Http\Controllers\Public\SimController::class, 'show'])->name('sim.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', function () {
        return view('auth.admin-login');
    })->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('logout');
});

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Requests Management
        Route::resource('requests', \App\Http\Controllers\Admin\RequestController::class);
        Route::get('requests/{request}/export-pdf', [\App\Http\Controllers\Admin\RequestController::class, 'exportPdf'])->name('requests.export-pdf');
        Route::get('requests/export-excel', [\App\Http\Controllers\Admin\RequestController::class, 'exportExcel'])->name('requests.export-excel');
        Route::patch('requests/{request}/update-status', [\App\Http\Controllers\Admin\RequestController::class, 'updateStatus'])->name('requests.update-status');
        
        // Warehouses Management
        Route::resource('warehouses', \App\Http\Controllers\Admin\WarehouseController::class);
        
        // Stocks Management
        // Place history routes BEFORE resource to avoid conflict with stocks/{stock}
        Route::get('stocks/movements', [\App\Http\Controllers\Admin\StockController::class, 'movements'])->name('stocks.movements');
        Route::get('stocks/movements/{movement}/receipt', [\App\Http\Controllers\Admin\StockController::class, 'movementReceipt'])->name('stocks.movement-receipt');
        Route::resource('stocks', \App\Http\Controllers\Admin\StockController::class);
        Route::post('stocks/{stock}/add', [\App\Http\Controllers\Admin\StockController::class, 'add'])->name('stocks.add');
        Route::post('stocks/{stock}/remove', [\App\Http\Controllers\Admin\StockController::class, 'remove'])->name('stocks.remove');
        
        // Personnel Management (Admin only: Ajouter / Modifier / Supprimer)
        // Place export routes BEFORE resource to avoid conflict with personnel/{personnel}
        Route::get('personnel/export-pdf', [\App\Http\Controllers\Admin\PersonnelController::class, 'exportPdf'])->name('personnel.export-pdf');
        Route::get('personnel/export-excel', [\App\Http\Controllers\Admin\PersonnelController::class, 'exportExcel'])->name('personnel.export-excel');
        // Export d'une fiche individuelle en PDF (placer avant resource pour éviter les conflits)
        Route::get('personnel/{personnel}/export-pdf', [\App\Http\Controllers\Admin\PersonnelController::class, 'exportFichePdf'])->name('personnel.export-fiche-pdf');
        Route::resource('personnel', \App\Http\Controllers\Admin\PersonnelController::class);
        Route::delete('personnel/{personnel}/delete-photo', [\App\Http\Controllers\Admin\PersonnelController::class, 'deletePhoto'])->name('personnel.deletePhoto');
        // Suppression du workflow de validation/rejet
        // Route::post('personnel/{personnel}/valider', [...])->name('personnel.valider');
        // Route::post('personnel/{personnel}/rejeter', [...])->name('personnel.rejeter');
        
        // Public Content Management (placer AVANT resource pour éviter les conflits avec public-content/{id})
        Route::match(['put','post'], 'public-content/update-about', [\App\Http\Controllers\Admin\PublicContentController::class, 'updateAboutPage'])->name('public-content.update-about');
        Route::match(['put','post'], 'public-content/update-institution', [\App\Http\Controllers\Admin\PublicContentController::class, 'updateInstitutionPage'])->name('public-content.update-institution');
        Route::post('public-content/upload-document', [\App\Http\Controllers\Admin\PublicContentController::class, 'uploadDocument'])->name('public-content.upload-document');
        // Fallback GET si l'URL est ouverte manuellement
        Route::get('public-content/update-about', fn () => redirect()->route('admin.public-content.index'));
        Route::get('public-content/update-institution', fn () => redirect()->route('admin.public-content.index'));
        Route::resource('public-content', \App\Http\Controllers\Admin\PublicContentController::class);
        
        // Home Backgrounds Management
        Route::resource('backgrounds', \App\Http\Controllers\Admin\HomeBackgroundController::class)->except(['show']);
        Route::post('backgrounds/update-order', [\App\Http\Controllers\Admin\HomeBackgroundController::class, 'updateOrder'])->name('backgrounds.update-order');
        
        // Speeches Management
        Route::resource('speeches', \App\Http\Controllers\Admin\SpeechController::class);
        
        // Gallery Management
        Route::post('gallery/{galleryImage}/toggle-status', [\App\Http\Controllers\Admin\GalleryImageController::class, 'toggleStatus'])->name('gallery.toggle-status');
        Route::post('gallery/{galleryImage}/toggle-featured', [\App\Http\Controllers\Admin\GalleryImageController::class, 'toggleFeatured'])->name('gallery.toggle-featured');
        Route::resource('gallery', \App\Http\Controllers\Admin\GalleryImageController::class);
        
        // News Management
        Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
        Route::post('news/{id}/toggle-publish', [\App\Http\Controllers\Admin\NewsController::class, 'togglePublish'])->name('news.toggle-publish');
        
        // Contact Messages Management
        Route::resource('contact', \App\Http\Controllers\Admin\ContactMessageController::class);
        // Utiliser POST pour aligner avec les formulaires de la vue
        Route::post('contact/{contact}/mark-as-read', [\App\Http\Controllers\Admin\ContactMessageController::class, 'markAsRead'])->name('contact.mark-as-read');
        Route::post('contact/{contact}/mark-as-replied', [\App\Http\Controllers\Admin\ContactMessageController::class, 'markAsReplied'])->name('contact.mark-as-replied');
        Route::post('contact/{contact}/archive', [\App\Http\Controllers\Admin\ContactMessageController::class, 'archive'])->name('contact.archive');
        Route::get('contact/export-csv', [\App\Http\Controllers\Admin\ContactMessageController::class, 'exportCsv'])->name('contact.export-csv');
        
        // Newsletter Management (placer les routes spécifiques AVANT resource pour éviter les conflits)
        Route::get('newsletter/export-csv', [\App\Http\Controllers\Admin\NewsletterController::class, 'exportCsv'])->name('newsletter.export-csv');
        Route::post('newsletter/{subscriber}/toggle-active', [\App\Http\Controllers\Admin\NewsletterController::class, 'toggleActive'])->name('newsletter.toggle-active');
        Route::resource('newsletter', \App\Http\Controllers\Admin\NewsletterController::class);
        
        // Users Management
        // Notifications Management
        Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/preferences', [\App\Http\Controllers\Admin\NotificationController::class, 'updatePreferences'])->name('notifications.update-preferences');
        Route::post('notifications/test-email', [\App\Http\Controllers\Admin\NotificationController::class, 'testEmail'])->name('notifications.test-email');
        Route::post('notifications/send-digest', [\App\Http\Controllers\Admin\NotificationController::class, 'sendWeeklyDigest'])->name('notifications.send-digest');
        Route::get('notifications/email-config', [\App\Http\Controllers\Admin\NotificationController::class, 'emailConfig'])->name('notifications.email-config');
        Route::get('notifications/quick-setup', function() {
            return view('admin.notifications.quick-setup');
        })->name('notifications.quick-setup');

        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        
        // Audit Management
        Route::get('audit/export-csv', [\App\Http\Controllers\Admin\AuditLogController::class, 'exportCsv'])->name('audit.exportCsv');
        Route::post('audit/clear-old', [\App\Http\Controllers\Admin\AuditLogController::class, 'clearOld'])->name('audit.clearOld');
        Route::resource('audit', \App\Http\Controllers\Admin\AuditLogController::class);
        
        // Profile Management
        Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::put('profile/avatar', [\App\Http\Controllers\Admin\ProfileController::class, 'updateAvatar'])->name('profile.avatar');

        // Price Alerts Management
        Route::resource('price-alerts', \App\Http\Controllers\Admin\PriceAlertController::class);
        Route::post('price-alerts/{priceAlert}/resolve', [\App\Http\Controllers\Admin\PriceAlertController::class, 'resolve'])->name('price-alerts.resolve');
        Route::post('price-alerts/{priceAlert}/send-public-alert', [\App\Http\Controllers\Admin\PriceAlertController::class, 'sendPublicAlert'])->name('price-alerts.send-public-alert');

        // Tasks Management (Trello-like)
        Route::resource('tasks', \App\Http\Controllers\Admin\TaskController::class);
        Route::patch('tasks/{task}/update-status', [\App\Http\Controllers\Admin\TaskController::class, 'updateStatus'])->name('tasks.update-status');
        Route::patch('tasks/{task}/assign', [\App\Http\Controllers\Admin\TaskController::class, 'assign'])->name('tasks.assign');

        // Weekly Agenda Management
        Route::get('weekly-agenda/calendar', [\App\Http\Controllers\Admin\WeeklyAgendaController::class, 'calendar'])->name('weekly-agenda.calendar');
        Route::patch('weekly-agenda/{weeklyAgenda}/update-status', [\App\Http\Controllers\Admin\WeeklyAgendaController::class, 'updateStatus'])->name('weekly-agenda.update-status');
        Route::resource('weekly-agenda', \App\Http\Controllers\Admin\WeeklyAgendaController::class);

        // Technical Partners Management
        Route::get('technical-partners/export', [\App\Http\Controllers\Admin\TechnicalPartnerController::class, 'export'])->name('technical-partners.export');
        Route::post('technical-partners/reorder', [\App\Http\Controllers\Admin\TechnicalPartnerController::class, 'reorderPartners'])->name('technical-partners.reorder');
        Route::post('technical-partners/reorder', [\App\Http\Controllers\Admin\TechnicalPartnerController::class, 'reorderPartners'])->name('technical-partners.reorder-partners');
        Route::resource('technical-partners', \App\Http\Controllers\Admin\TechnicalPartnerController::class);

        // SIM Reports Management
        Route::resource('sim-reports', \App\Http\Controllers\Admin\SimReportController::class);
        Route::post('sim-reports/{simReport}/publish', [\App\Http\Controllers\Admin\SimReportController::class, 'publish'])->name('sim-reports.publish');
        Route::post('sim-reports/{simReport}/unpublish', [\App\Http\Controllers\Admin\SimReportController::class, 'unpublish'])->name('sim-reports.unpublish');
        Route::post('sim-reports/{simReport}/generate-alerts', [\App\Http\Controllers\Admin\SimReportController::class, 'generatePriceAlerts'])->name('sim-reports.generate-alerts');

        // Module RH
        Route::prefix('hr')->name('hr.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\HRController::class, 'index'])->name('index');
            Route::get('/statistics', [\App\Http\Controllers\Admin\HRController::class, 'statistics'])->name('statistics');
            
            // Documents RH
            Route::get('/documents', [\App\Http\Controllers\Admin\HRController::class, 'documents'])->name('documents.index');
            Route::get('/documents/create', [\App\Http\Controllers\Admin\HRController::class, 'createDocument'])->name('documents.create');
            Route::post('/documents', [\App\Http\Controllers\Admin\HRController::class, 'storeDocument'])->name('documents.store');
            Route::get('/documents/{document}', [\App\Http\Controllers\Admin\HRController::class, 'showDocument'])->name('documents.show');
            Route::get('/documents/{document}/edit', [\App\Http\Controllers\Admin\HRController::class, 'editDocument'])->name('documents.edit');
            Route::put('/documents/{document}', [\App\Http\Controllers\Admin\HRController::class, 'updateDocument'])->name('documents.update');
            Route::delete('/documents/{document}', [\App\Http\Controllers\Admin\HRController::class, 'destroyDocument'])->name('documents.destroy');
            Route::get('/documents/{document}/download', [\App\Http\Controllers\Admin\HRController::class, 'downloadDocument'])->name('documents.download');
            
            // Présence au travail
            Route::get('/attendance', [\App\Http\Controllers\Admin\HRController::class, 'attendance'])->name('attendance.index');
            Route::get('/attendance/create', [\App\Http\Controllers\Admin\HRController::class, 'createAttendance'])->name('attendance.create');
            Route::post('/attendance', [\App\Http\Controllers\Admin\HRController::class, 'storeAttendance'])->name('attendance.store');
            Route::get('/attendance/{attendance}/edit', [\App\Http\Controllers\Admin\HRController::class, 'editAttendance'])->name('attendance.edit');
            Route::put('/attendance/{attendance}', [\App\Http\Controllers\Admin\HRController::class, 'updateAttendance'])->name('attendance.update');
            Route::delete('/attendance/{attendance}', [\App\Http\Controllers\Admin\HRController::class, 'destroyAttendance'])->name('attendance.destroy');
        });

});

// DG Routes
Route::prefix('dg')->name('dg.')->group(function () {
    Route::get('/login', function () {
        return view('auth.dg-login');
    })->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login.submit');
    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
        Route::get('/', [\App\Http\Controllers\DG\DashboardController::class, 'index'])->name('dashboard');
        
        // Requests Management
        Route::get('requests', [\App\Http\Controllers\DG\RequestController::class, 'index'])->name('requests.index');
        Route::get('requests/{id}', [\App\Http\Controllers\DG\RequestController::class, 'show'])->name('requests.show');
        Route::get('requests/export', [\App\Http\Controllers\DG\RequestController::class, 'export'])->name('requests.export');
        Route::post('requests/{id}/approve', [\App\Http\Controllers\DG\RequestController::class, 'approve'])->name('requests.approve');
        Route::post('requests/{id}/reject', [\App\Http\Controllers\DG\RequestController::class, 'reject'])->name('requests.reject');
        Route::post('requests/{id}/complete', [\App\Http\Controllers\DG\RequestController::class, 'complete'])->name('requests.complete');
        
        // Warehouses Management (read-only)
        Route::get('warehouses', [\App\Http\Controllers\DG\WarehouseController::class, 'index'])->name('warehouses.index');
        Route::get('warehouses/{id}', [\App\Http\Controllers\DG\WarehouseController::class, 'show'])->name('warehouses.show');
        
        // Personnel Management (read-only)
        Route::get('personnel', [\App\Http\Controllers\DG\PersonnelController::class, 'index'])->name('personnel.index');
        Route::get('personnel/{id}', [\App\Http\Controllers\DG\PersonnelController::class, 'show'])->name('personnel.show');
        Route::get('personnel/export', [\App\Http\Controllers\DG\PersonnelController::class, 'export'])->name('personnel.export');
        Route::get('personnel/export-pdf', [\App\Http\Controllers\DG\PersonnelController::class, 'exportPdf'])->name('personnel.export-pdf');
        Route::get('personnel/export-excel', [\App\Http\Controllers\DG\PersonnelController::class, 'exportExcel'])->name('personnel.export-excel');
        
        // Messages Management (read-only)
        Route::get('messages', [\App\Http\Controllers\DG\MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{id}', [\App\Http\Controllers\DG\MessageController::class, 'show'])->name('messages.show');
        
        // Public Content Management (read-only)
        Route::get('public-content', [\App\Http\Controllers\DG\PublicContentController::class, 'index'])->name('public-content.index');
        Route::get('public-content/{id}', [\App\Http\Controllers\DG\PublicContentController::class, 'show'])->name('public-content.show');
        Route::get('news', [\App\Http\Controllers\DG\PublicContentController::class, 'news'])->name('news.index');
        Route::get('news/{id}', [\App\Http\Controllers\DG\PublicContentController::class, 'showNews'])->name('news.show');
        Route::get('speeches', [\App\Http\Controllers\DG\PublicContentController::class, 'speeches'])->name('speeches.index');
        Route::get('gallery', [\App\Http\Controllers\DG\PublicContentController::class, 'gallery'])->name('gallery.index');
        Route::get('reports', [\App\Http\Controllers\DG\PublicContentController::class, 'reports'])->name('reports.index');
        
        // Newsletter Management (read-only)
        Route::get('newsletter', [\App\Http\Controllers\DG\NewsletterController::class, 'index'])->name('newsletter.index');
        Route::get('newsletter/{id}', [\App\Http\Controllers\DG\NewsletterController::class, 'show'])->name('newsletter.show');
        Route::get('newsletter/export/csv', [\App\Http\Controllers\DG\NewsletterController::class, 'exportCsv'])->name('newsletter.export-csv');
        Route::get('newsletter/history', [\App\Http\Controllers\DG\NewsletterController::class, 'history'])->name('newsletter.history');
        
        // Map (read-only)
        Route::get('map', [\App\Http\Controllers\DG\MapController::class, 'index'])->name('map');
        
        // Profile Management
        Route::get('profile', [\App\Http\Controllers\DG\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [\App\Http\Controllers\DG\ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [\App\Http\Controllers\DG\ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Responsable Routes (Entrepôt)
Route::prefix('entrepot')->name('responsable.')->group(function () {
    Route::get('/login', function () {
        return view('auth.responsable-login');
    })->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login.submit');
    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    
        Route::get('/', [\App\Http\Controllers\Responsable\DashboardController::class, 'index'])->name('dashboard');
        
        // Stock Management
        Route::get('stock', [\App\Http\Controllers\Responsable\StockController::class, 'index'])->name('stock');
        Route::get('stock/create', [\App\Http\Controllers\Responsable\StockController::class, 'create'])->name('stock.create');
        Route::post('stock', [\App\Http\Controllers\Responsable\StockController::class, 'store'])->name('stock.store');
        Route::get('stock/out', [\App\Http\Controllers\Responsable\StockController::class, 'createOut'])->name('stock.out');
        Route::post('stock/out', [\App\Http\Controllers\Responsable\StockController::class, 'storeOut'])->name('stock.out.store');
        
        // Movements History
        Route::get('movements', [\App\Http\Controllers\Responsable\StockController::class, 'movements'])->name('movements');
        Route::get('movements/export-pdf', [\App\Http\Controllers\Responsable\StockController::class, 'exportMovementsPdf'])->name('movements.export-pdf');
        Route::get('movements/export-excel', [\App\Http\Controllers\Responsable\StockController::class, 'exportMovementsExcel'])->name('movements.export-excel');
        
        // Location Management
        Route::get('location', [\App\Http\Controllers\Responsable\StockController::class, 'location'])->name('location');
        Route::put('location', [\App\Http\Controllers\Responsable\StockController::class, 'updateLocation'])->name('location.update');
        
        // Profile Management
        Route::get('profile', [\App\Http\Controllers\Responsable\StockController::class, 'profile'])->name('profile');
        Route::put('profile', [\App\Http\Controllers\Responsable\StockController::class, 'updateProfile'])->name('profile.update');
});

// Agent Routes
Route::prefix('agent')->name('agent.')->group(function () {
    // Login routes (no middleware)
    Route::get('/login', function () {
        return view('auth.agent-login');
    })->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login.submit');
    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Protected routes (with middleware)
    Route::middleware('agent')->group(function () {
    Route::get('/', [\App\Http\Controllers\Agent\DashboardController::class, 'index'])->name('dashboard');
    Route::get('salary-slips/{salarySlip}/download', [\App\Http\Controllers\Agent\HRController::class, 'downloadSalarySlip'])->name('salary-slips.download');
    Route::get('profile', [\App\Http\Controllers\Agent\ProfileController::class, 'index'])->name('profile');
    Route::get('profile/edit', [\App\Http\Controllers\Agent\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\Agent\ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/change-password', [\App\Http\Controllers\Agent\ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('profile/password', [\App\Http\Controllers\Agent\ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::get('profile/pdf', [\App\Http\Controllers\Agent\ProfileController::class, 'downloadPdf'])->name('profile.pdf');
    Route::get('profile/show', [\App\Http\Controllers\Agent\ProfileController::class, 'show'])->name('profile.show');
    Route::prefix('hr')->name('hr.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Agent\HRController::class, 'index'])->name('index');
        Route::get('documents', [\App\Http\Controllers\Agent\HRController::class, 'documents'])->name('documents.index');
        Route::get('documents/{document}', [\App\Http\Controllers\Agent\HRController::class, 'showDocument'])->name('documents.show');
        Route::get('documents/{document}/download', [\App\Http\Controllers\Agent\HRController::class, 'downloadDocument'])->name('documents.download');
        Route::get('salary-slips', [\App\Http\Controllers\Agent\HRController::class, 'salarySlips'])->name('salary-slips.index');
        Route::get('salary-slips/{salarySlip}', [\App\Http\Controllers\Agent\HRController::class, 'showSalarySlip'])->name('salary-slips.show');
        Route::get('salary-slips/{salarySlip}/download', [\App\Http\Controllers\Agent\HRController::class, 'downloadSalarySlip'])->name('salary-slips.download');
        Route::get('attendance', [\App\Http\Controllers\Agent\HRController::class, 'attendance'])->name('attendance.index');
        Route::get('statistics', [\App\Http\Controllers\Agent\HRController::class, 'statistics'])->name('statistics');
    });
    }); // Fin du middleware agent
}); // Fin du prefix agent

