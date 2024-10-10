<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[App\Http\Controllers\HomeController::class, 'VisitorConferences'] );

Auth::routes();

Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home');
Route::get('/user/home', [App\Http\Controllers\HomeController::class, 'userHome'])->name('user.home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'VisitorConferences'])->name('home');
Route::get('/home/search', [App\Http\Controllers\HomeController::class, 'SearchVisitorConference'])->name('home.search');
Route::get('/home/{type}/{id}',[\App\Http\Controllers\ConferenceController::class, 'ShowVisitorConference']);
Route::get('/home/{type}/{id}/search',[\App\Http\Controllers\ConferenceController::class, 'SearchVisitorsPapers'])->name('home.paper.search');




Route::get('/admin/users',[App\Http\Controllers\ManageUsers::class,'ShowUsers'])->name('manage.users');
Route::get('/admin/admins',[App\Http\Controllers\ManageUsers::class,'ShowAdmins'])->name('manage.admins');
Route::get('/admin/requests',[App\Http\Controllers\ManageUsers::class,'Requests'])->name('manage.requests');
Route::get('/admin/update',[App\Http\Controllers\ManageUsers::class,'UpdateUser'])->name('manage.update');
Route::get('/admin/unlocked/{type}',[App\Http\Controllers\ManageUsers::class,'ShowTypeOfUsers_Unlocked'])->name('manage.unlocked');
Route::get('/admin/locked/{type}',[App\Http\Controllers\ManageUsers::class,'ShowTypeOfUsers_Locked'])->name('manage.locked');
Route::get('/admin/search/{type}',[App\Http\Controllers\ManageUsers::class,'SearchUser'])->name('manage.search');
Route::get('/admin/delete',[App\Http\Controllers\ManageUsers::class,'DeleteUser'])->name('manage.delete');

Route::get('/myprofile',[App\Http\Controllers\ProfileController::class,'ShowMyProfile'])->name('my.profile');
Route::get('/myprofile/update',[App\Http\Controllers\ProfileController::class,'UpdateProfile'])->name('my.profile.update');
Route::get('/myprofile/changepassword',[App\Http\Controllers\ProfileController::class,'ChangePassword'])->name('my.profile.change.password');
Route::get('/myprofile/deleterequest',[App\Http\Controllers\ProfileController::class,'DeleteRequest'])->name('my.profile.delete');

Route::get('/myconferences/{type}',[App\Http\Controllers\UsersConferencesController::class,'ShowConferences'])->name('my.conferences');
Route::get('/myconferences/{type}/create' ,[App\Http\Controllers\UsersConferencesController::class,'CreateNewConference'])->name('my.conferences.create');
Route::get('/myconferences/{type}/delete',[App\Http\Controllers\UsersConferencesController::class,'DeleteConference'])->name('my.conferences.delete');
Route::get('/myconferences/{type}/update',[App\Http\Controllers\UsersConferencesController::class,'UpdateConference'])->name('my.conferences.update');
Route::get('/myconferences/{type}/search',[App\Http\Controllers\UsersConferencesController::class,'SearchConferences'])->name('my.conferences.search');
Route::get('/myconferences/{type}/dates',[App\Http\Controllers\UsersConferencesController::class,'DefineDates'])->name('my.conferences.dates');
Route::get('/myconference/{type}/add/members',[App\Http\Controllers\UsersConferencesController::class,'AddDeleteMembers'])->name('my.conference.members');

Route::get('/myconferences/{type}/{id}',[App\Http\Controllers\ConferenceController::class,'ShowConference']);
Route::get('/myconferences/{type}/{id}/create',[App\Http\Controllers\ConferenceController::class,'SubmitPaper'])->name('paper.submit');
Route::get('/myconference/{type}/{id}/add/authors',[App\Http\Controllers\ConferenceController::class,'AddAuthors'])->name('paper.authors');
Route::get('/myconference/{type}/{id}/update',[App\Http\Controllers\ConferenceController::class,'UpdatePaper'])->name('paper.update');
Route::get('/myconference/{type}/{id}/delete',[App\Http\Controllers\ConferenceController::class,'DeletePaper'])->name('paper.delete');
Route::get('/myconference/{type}/{id}/search',[App\Http\Controllers\ConferenceController::class,'SearchPapers'])->name('paper.search');
Route::get('/myconference/{type}/{id}/add/reviewers',[App\Http\Controllers\ConferenceController::class,'AddReviewers'])->name('paper.reviewers');
Route::get('/myconference/{type}/{id}/update/review',[App\Http\Controllers\ConferenceController::class,'UpdateReview'])->name('paper.review');
Route::get('/myconference/{type}/{id}/approve',[App\Http\Controllers\ConferenceController::class,'ApprovePaper'])->name('paper.approve');
Route::get('/myconference/{type}/{id}/disapprove',[App\Http\Controllers\ConferenceController::class,'DisapprovedPaper'])->name('paper.disapprove');
Route::get('/viewpaper',[App\Http\Controllers\ConferenceController::class,'ViewPaper']);
Route::get('/viewpapervisitor',[App\Http\Controllers\ConferenceController::class,'ViewPaperVisitor']);

Route::get('/viewreview',[App\Http\Controllers\ConferenceController::class,'ReturnReviews']);
Route::get('/checkifreviewer',[App\Http\Controllers\ConferenceController::class,'CheckIfReviewer']);

Route::get('/finalize',[App\Http\Controllers\ConferenceController::class,'finalizeConference']);

