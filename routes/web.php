<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewerAssignmentController;
use App\Http\Controllers\RevisiController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\CheckAuthMiddleware;
use App\Http\Middleware\OperatorMiddleware;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');

    Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/register/create', [RegisterController::class, 'register'])->name('register');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', AuthMiddleware::class])->group(function () {

    Route::get('/dashboard', function () {
        $hitung = DB::select('CALL GetUserCounts()');
        $counts = DB::select('Call GetCounts()');

        return view('dashboard', [
            'users' => $hitung[0]->total_users,
            'approved_users' => $hitung[0]->approved_users,
            'total_proposal' => $counts[0]->total_proposals,
            'total_tim' => $counts[0]->total_teams,
        ]);
    });

    // Proposal Controller
    Route::get('/my-proposal/{id}', [ProposalController::class, 'index'])->name('proposal.index');
    Route::get('/proposal/create', [ProposalController::class, 'create'])->name('proposal.create');
    Route::post('/proposal/store', [ProposalController::class, 'store'])->name('proposal.store');
    Route::get('/proposal/edit/{id}', [ProposalController::class, 'edit'])->name('proposal.edit');
    Route::put('/proposal/update/{id}', [ProposalController::class, 'update'])->name('proposal.update');
    Route::delete('/proposal/delete/{id}', [ProposalController::class, 'delete'])->name('proposal.delete');
    Route::get('/proposal/show/{id}', [ProposalController::class, 'show'])->name('proposal.show');

    Route::get('/manajemen-proposal/all', [ProposalController::class, 'indexOperator'])->name('operator.proposal.index');
    Route::get('/manajemen-proposal/detail/{nama_tim}/{proposal_id}', [ProposalController::class, 'detailProposal'])->name('operator.proposal.detail');

    Route::get('/reviewers', [ReviewerAssignmentController::class, 'index'])->name('reviewers.index');
    Route::get('/reviewers/assign-reviewer', [ReviewerAssignmentController::class, 'showAssignForm'])->name('reviewers.assign');
    Route::post('/assign-reviewer', [ReviewerAssignmentController::class, 'assign'])->name('reviewer.assign.save');
    Route::delete('/reviewer/assignment/{reviewer_id}/{team_id}', [ReviewerAssignmentController::class, 'deleteAssignment'])
        ->name('reviewer.assignment.delete');


    // file controller
    Route::get('/file/view/{folder}/{filename}', [FileController::class, 'viewFile'])->name('file.view');
    Route::get('/file/download/{folder}/{filename}', [FileController::class, 'downloadFile'])->name('file.download');


    // Review & revisi
    Route::post('/review/{proposal_id}', [ReviewController::class, 'store'])->name('review.store');
    Route::post('/revisi/{proposal_id}', [RevisiController::class, 'store'])->name('revisi.store');

    // Tim Controller
    Route::get('/my-tim/{tim_id}', [TimController::class, 'index'])->name('tim.index');
    Route::get('/tim/create', [TimController::class, 'create'])->name('tim.create');
    Route::post('/tim/store', [TimController::class, 'store'])->name('tim.store');
    Route::get('/tim/edit/{id}', [TimController::class, 'edit'])->name('tim.edit');
    Route::put('/tim/update/{id}', [TimController::class, 'update'])->name('tim.update');
    Route::get('/tim/delete/{id}', [TimController::class, 'delete'])->name('tim.delete');

    Route::post('/tim/{tim_id}/addAnggota', [TimController::class, 'addAnggota'])->name('tim.anggota.add');
    Route::post('/tim/{tim_id}/editAnggota/{user_id}', [TimController::class, 'editAnggota'])->name('tim.anggota.edit');
    Route::delete('/tim/{tim}/anggota/{user}', [TimController::class, 'removeAnggota'])->name('tim.anggota.remove');





});


Route::middleware(['auth', 'operator'])->group(function () {

    // UserController
    Route::get('/user/all', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::post('/approve-user/{id}', [UserController::class, 'approveUser'])->name('user.approve');
    Route::post('/decline-user/{id}', [UserController::class, 'declineUser'])->name('user.decline');


    // Reviewer Assigment
    Route::get('/reviewer-assignments', [ReviewerAssignmentController::class, 'index'])->name('reviewer.assignments');
    Route::post('/reviewer-assignments', [ReviewerAssignmentController::class, 'assign'])->name('reviewer.assign');
    Route::delete('/reviewer-assignments', [ReviewerAssignmentController::class, 'remove'])->name('reviewer.remove');

});