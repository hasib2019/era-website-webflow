<?php

use App\Http\Controllers\Site\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site
|--------------------------------------------------------------------------
| Paths mirror the ones the Webflow export already linked to, so the detail
| pages keep the slugs that were baked into the template's own navigation.
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/services', [PageController::class, 'services'])->name('services.index');
Route::get('/services/{slug}', [PageController::class, 'serviceDetails'])->name('services.show');

Route::get('/case-studies', [PageController::class, 'caseStudies'])->name('case-studies.index');
Route::get('/case-studies/{slug}', [PageController::class, 'caseStudyDetails'])->name('case-studies.show');

Route::get('/blog', [PageController::class, 'blog'])->name('blog.index');
Route::get('/blog/{slug}', [PageController::class, 'blogDetails'])->name('blog.show');

Route::get('/career', [PageController::class, 'career'])->name('career.index');
Route::get('/career/{slug}', [PageController::class, 'careerDetails'])->name('career.show');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/why-choose-us', [PageController::class, 'whyChooseUs'])->name('why-choose-us');
Route::get('/changelog', [PageController::class, 'changelog'])->name('changelog');
Route::get('/style-guide', [PageController::class, 'styleGuide'])->name('style-guide');

// The template ships a styled not-found page and links to it from the footer,
// so it stays reachable as a real route as well as the error handler's view.
Route::get('/404', fn () => response()->view('errors.404', [], 404))->name('not-found');
