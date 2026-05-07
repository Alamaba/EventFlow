<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\OrganisateurController;
use App\Http\Controllers\Admin\EventValidationController;
use App\Http\Controllers\Organisateur\DashboardController as OrgDashboard;
use App\Http\Controllers\Organisateur\EventController;
use App\Http\Controllers\Organisateur\GuestController;
use App\Http\Controllers\Organisateur\TicketController;
use App\Http\Controllers\Organisateur\StaffController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboard;
use App\Http\Controllers\Agent\ScanController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route(auth()->user()->role . '.dashboard');
    }
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->get('/dashboard', function () {
    return redirect()->route(auth()->user()->role . '.dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================== ADMIN =====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('organisateurs', OrganisateurController::class);
    Route::patch('organisateurs/{user}/toggle-status', [OrganisateurController::class, 'toggleStatus'])->name('organisateurs.toggle-status');
    Route::get('events', [EventValidationController::class, 'index'])->name('events.index');
    Route::patch('events/{event}/publish', [EventValidationController::class, 'publish'])->name('events.publish');
    Route::patch('events/{event}/cancel', [EventValidationController::class, 'cancel'])->name('events.cancel');
});

// ===================== ORGANISATEUR =====================
Route::middleware(['auth', 'role:organisateur'])->prefix('organisateur')->name('organisateur.')->group(function () {
    Route::get('/dashboard', [OrgDashboard::class, 'index'])->name('dashboard');
    Route::resource('events', EventController::class);
    Route::post('events/{event}/publish', [EventController::class, 'publish'])->name('events.publish');
    Route::resource('events.guests', GuestController::class)->shallow();
    Route::post('guests/import', [GuestController::class, 'import'])->name('guests.import');
    Route::post('guests/{guest}/send-invitation', [GuestController::class, 'sendInvitation'])->name('guests.send-invitation');
    Route::post('events/{event}/send-all-invitations', [GuestController::class, 'sendAllInvitations'])->name('events.send-all-invitations');
    Route::get('events/{event}/tickets', [TicketController::class, 'index'])->name('events.tickets.index');
    Route::post('events/{event}/tickets/generate-all', [TicketController::class, 'generateAll'])->name('events.tickets.generate-all');
    Route::get('tickets/{ticket}/download', [TicketController::class, 'download'])->name('tickets.download');
    Route::get('events/{event}/staff', [StaffController::class, 'index'])->name('events.staff.index');
    Route::post('events/{event}/staff', [StaffController::class, 'store'])->name('events.staff.store');
    Route::delete('events/{event}/staff/{user}', [StaffController::class, 'destroy'])->name('events.staff.destroy');
    Route::get('events/{event}/stats', [EventController::class, 'stats'])->name('events.stats');
});

// ===================== AGENT =====================
Route::middleware(['auth', 'role:agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', [AgentDashboard::class, 'index'])->name('dashboard');
    Route::get('/events/{event}/scan', [ScanController::class, 'index'])->name('events.scan');
    Route::post('/scan', [ScanController::class, 'scan'])->name('scan.process');
    Route::get('/events/{event}/guests', [AgentDashboard::class, 'guestList'])->name('events.guests');
});

// ===================== INVITÉ (public) =====================
Route::get('/ticket/{uuid}', [InviteController::class, 'show'])->name('ticket.show');
Route::post('/ticket/{uuid}/rsvp', [InviteController::class, 'rsvp'])->name('ticket.rsvp');
Route::get('/ticket/{uuid}/download', [InviteController::class, 'download'])->name('ticket.download');

// ===================== PAIEMENT =====================
Route::middleware('auth')->prefix('payment')->name('payment.')->group(function () {
    Route::get('/{event}/checkout', [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/{event}/process', [PaymentController::class, 'process'])->name('process');
    Route::get('/success', [PaymentController::class, 'success'])->name('success');
    Route::get('/cancel', [PaymentController::class, 'cancel'])->name('cancel');
});
Route::post('/stripe/webhook', [PaymentController::class, 'webhook'])->name('stripe.webhook');
