<?php

use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\AssessmentController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BatchController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\CalendarController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\LearnerController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\PublicCertificateController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TrainerController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::middleware('auth:sanctum')->group(function(){
            Route::get('me', [AuthController::class, 'me']);
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('switch-organization', [AuthController::class, 'switchOrganization']);
        });
    });

    Route::get('public/certificates/{number}', [PublicCertificateController::class, 'show']);

    Route::middleware(['auth:sanctum','tenant'])->group(function () {
        Route::get('dashboard', DashboardController::class)->middleware('permission:view.dashboard');
        Route::get('analytics', AnalyticsController::class)->middleware('permission:view.analytics');
        Route::get('calendar', CalendarController::class)->middleware('permission:view.dashboard');

        Route::get('organizations', [OrganizationController::class, 'index']);
        Route::get('organizations/current', [OrganizationController::class, 'current']);
        Route::post('organizations/switch', [OrganizationController::class, 'switch']);

        Route::middleware('permission:view.learners')->group(function(){
            Route::get('learners', [LearnerController::class,'index']);
            Route::get('learners/{learner}', [LearnerController::class,'show']);
            Route::get('learners/{learner}/attendance', [LearnerController::class,'attendance']);
        });
        Route::middleware('permission:manage.learners')->group(function(){
            Route::post('learners', [LearnerController::class,'store']);
            Route::put('learners/{learner}', [LearnerController::class,'update']);
            Route::patch('learners/{learner}', [LearnerController::class,'update']);
            Route::delete('learners/{learner}', [LearnerController::class,'destroy']);
            Route::post('learners/{learner}/enroll', [LearnerController::class,'enroll']);
        });

        Route::middleware('permission:view.trainers')->group(function(){
            Route::get('trainers', [TrainerController::class,'index']);
            Route::get('trainers/{trainer}', [TrainerController::class,'show']);
        });
        Route::middleware('permission:manage.trainers')->group(function(){
            Route::post('trainers', [TrainerController::class,'store']);
            Route::put('trainers/{trainer}', [TrainerController::class,'update']);
            Route::patch('trainers/{trainer}', [TrainerController::class,'update']);
            Route::delete('trainers/{trainer}', [TrainerController::class,'destroy']);
        });

        Route::middleware('permission:view.courses')->group(function(){
            Route::get('courses', [CourseController::class,'index']);
            Route::get('courses/{course}', [CourseController::class,'show']);
            Route::get('courses/{course}/modules', [CourseController::class,'modules']);
            Route::get('courses/{course}/materials/{material}/download', [CourseController::class,'downloadMaterial']);
        });
        Route::middleware('permission:manage.courses')->group(function(){
            Route::post('courses', [CourseController::class,'store']);
            Route::put('courses/{course}', [CourseController::class,'update']);
            Route::patch('courses/{course}', [CourseController::class,'update']);
            Route::delete('courses/{course}', [CourseController::class,'destroy']);
            Route::post('courses/{course}/modules', [CourseController::class,'storeModule']);
            Route::delete('courses/{course}/modules/{module}', [CourseController::class,'destroyModule']);
            Route::post('courses/{course}/materials', [CourseController::class,'storeMaterial']);
            Route::post('courses/{course}/trainers', [CourseController::class,'syncTrainers']);
        });

        Route::middleware('permission:view.batches')->group(function(){
            Route::get('batches', [BatchController::class,'index']);
            Route::get('batches/{batch}', [BatchController::class,'show']);
            Route::get('batches/{batch}/sessions', [BatchController::class,'sessions']);
        });
        Route::middleware('permission:manage.batches')->group(function(){
            Route::post('batches', [BatchController::class,'store']);
            Route::put('batches/{batch}', [BatchController::class,'update']);
            Route::patch('batches/{batch}', [BatchController::class,'update']);
            Route::delete('batches/{batch}', [BatchController::class,'destroy']);
            Route::post('batches/{batch}/enroll', [BatchController::class,'enroll']);
            Route::delete('batches/{batch}/learners/{learnerId}', [BatchController::class,'unenroll']);
            Route::post('batches/{batch}/sessions', [BatchController::class,'storeSession']);
            Route::put('batches/{batch}/sessions/{session}', [BatchController::class,'updateSession']);
            Route::delete('batches/{batch}/sessions/{session}', [BatchController::class,'destroySession']);
        });

        Route::middleware('permission:view.assessments')->group(function(){
            Route::get('assessments', [AssessmentController::class,'index']);
            Route::get('assessments/{assessment}', [AssessmentController::class,'show']);
            Route::get('assessments/{assessment}/results', [AssessmentController::class,'results']);
        });
        Route::middleware('permission:manage.assessments')->group(function(){
            Route::post('assessments', [AssessmentController::class,'store']);
            Route::put('assessments/{assessment}', [AssessmentController::class,'update']);
            Route::patch('assessments/{assessment}', [AssessmentController::class,'update']);
            Route::delete('assessments/{assessment}', [AssessmentController::class,'destroy']);
            Route::post('assessments/{assessment}/submit', [AssessmentController::class,'submit']);
        });

        Route::middleware('permission:view.certificates')->group(function(){
            Route::get('certificates', [CertificateController::class,'index']);
            Route::get('certificates/{certificate}', [CertificateController::class,'show']);
            Route::get('certificates/{certificate}/download', [CertificateController::class,'download']);
            Route::get('certificate-templates', [CertificateController::class,'templates']);
        });
        Route::middleware('permission:manage.certificates')->group(function(){
            Route::post('certificate-templates', [CertificateController::class,'storeTemplate']);
            Route::post('certificates/generate', [CertificateController::class,'generate']);
            Route::post('certificates/{certificate}/revoke', [CertificateController::class,'revoke']);
        });

        Route::middleware('permission:manage.attendance')->group(function(){
            Route::get('attendance', [AttendanceController::class,'index']);
            Route::post('sessions/{session}/attendance', [AttendanceController::class,'store']);
            Route::get('sessions/{session}/attendance', [AttendanceController::class,'session']);
        });

        Route::middleware('permission:manage.documents')->group(function(){
            Route::apiResource('documents', DocumentController::class)->only(['index','store','show','destroy']);
            Route::get('documents/{document}/versions/{version}/download', [DocumentController::class,'download']);
        });

        Route::middleware('permission:view.reports')->group(function(){
            Route::get('reports', [ReportController::class,'index']);
            Route::get('reports/{type}', [ReportController::class,'show']);
            Route::get('reports/{type}/csv', [ReportController::class,'exportCsv']);
        });

        Route::get('notifications', [NotificationController::class,'index']);
        Route::post('notifications/{notification}/read', [NotificationController::class,'read']);
        Route::post('notifications/read-all', [NotificationController::class,'readAll']);

        Route::middleware('permission:manage.team')->group(function(){
            Route::get('team', [TeamController::class,'index']);
            Route::post('team', [TeamController::class,'store']);
            Route::patch('team/{user}', [TeamController::class,'update']);
            Route::delete('team/{user}', [TeamController::class,'remove']);
            Route::get('roles', [TeamController::class,'roles']);
            Route::get('roles/permissions', [TeamController::class,'permissions']);
        });

        Route::middleware('permission:manage.settings')->group(function(){
            Route::get('settings', [SettingsController::class,'show']);
            Route::patch('settings', [SettingsController::class,'update']);
            Route::post('settings/branding', [SettingsController::class,'branding']);
        });
        Route::patch('settings/profile', [SettingsController::class,'profile']);
    });
});
