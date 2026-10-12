<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Learner;
use App\Models\Trainer;
use App\Models\Batch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view.dashboard','view.learners','view.trainers','view.courses','view.batches','view.assessments','view.certificates','view.documents','manage.organization','manage.team','manage.learners','manage.trainers','manage.courses','manage.batches',
            'manage.attendance','manage.assessments','manage.certificates','manage.documents','view.reports','view.analytics','manage.settings'
        ];
        foreach ($permissions as $name) Permission::firstOrCreate(['name'=>$name], ['label'=>ucwords(str_replace(['.','_'],' ', $name))]);

        $roles = [
            'owner' => ['name'=>'Owner','description'=>'Organization owner'],
            'admin' => ['name'=>'Admin','description'=>'Organization administrator'],
            'manager' => ['name'=>'Manager','description'=>'Training operations manager'],
            'trainer' => ['name'=>'Trainer','description'=>'Trainer role'],
            'learner' => ['name'=>'Learner','description'=>'Learner role'],
            'client' => ['name'=>'Client','description'=>'Corporate client coordinator'],
        ];
        foreach ($roles as $slug=>$data) Role::firstOrCreate(['slug'=>$slug], ['name'=>$data['name'],'description'=>$data['description'],'system'=>true]);

        $all = Permission::pluck('id')->all();
        foreach (['owner','admin'] as $roleSlug) {
            $role=Role::where('slug',$roleSlug)->first(); $role->permissions()->sync($all);
        }
        foreach (['manager'=>['view.learners','view.trainers','view.courses','view.batches','view.assessments','view.certificates','view.documents','manage.learners','manage.trainers','manage.courses','manage.batches','manage.attendance','manage.assessments','manage.certificates','manage.documents','view.reports','view.analytics'], 'trainer'=>['view.dashboard','view.learners','view.courses','view.batches','view.assessments','view.documents','manage.attendance','manage.assessments','manage.documents'],'learner'=>['view.dashboard'],'client'=>['view.dashboard','view.reports']] as $slug=>$names) {
            $role=Role::where('slug',$slug)->first(); $role->permissions()->sync(Permission::whereIn('name',$names)->pluck('id')->all());
        }

        $org = Organization::firstOrCreate(['slug'=>'demo-training-academy'], [
            'name'=>'Demo Training Academy','country'=>'United Arab Emirates','timezone'=>'Asia/Dubai','currency'=>'AED','status'=>'active',
            'settings'=>['certificate_prefix'=>'TRN','default_attendance_threshold'=>75],
        ]);
        $ownerRole=Role::where('slug','owner')->first();
        $owner=User::firstOrCreate(['email'=>'owner@trainingos.test'], ['name'=>'Nibras Admin','password'=>Hash::make('password'),'active_organization_id'=>$org->id]);
        if (!$org->users()->whereKey($owner->id)->exists()) $org->users()->attach($owner->id,['role_id'=>$ownerRole->id,'status'=>'active']);

        $course=Course::firstOrCreate(['organization_id'=>$org->id,'code'=>'LAR-101'], ['name'=>'Laravel Fundamentals','slug'=>'laravel-fundamentals','category'=>'Development','description'=>'Production-oriented Laravel foundations.','duration_hours'=>24,'level'=>'Intermediate','status'=>'active','published_at'=>now()]);
        foreach (['Introduction','Architecture','Routing & Controllers','Database & Eloquent','Authentication & Authorization','REST APIs','Testing & Deployment'] as $i=>$title) CourseModule::firstOrCreate(['organization_id'=>$org->id,'course_id'=>$course->id,'sort_order'=>$i+1], ['title'=>$title,'description'=>$title.' module','duration_minutes'=>180,'status'=>'active']);
        $learner = Learner::firstOrCreate(['organization_id'=>$org->id,'learner_number'=>'LRN-0001'], ['first_name'=>'Sara','last_name'=>'Ahmed','email'=>'sara@example.test','company'=>'Example LLC','status'=>'active']);
        $trainerUser=User::firstOrCreate(['email'=>'trainer@trainingos.test'], ['name'=>'Ahmed Trainer','password'=>Hash::make('password'),'active_organization_id'=>$org->id]);
        if (!$org->users()->whereKey($trainerUser->id)->exists()) $org->users()->attach($trainerUser->id,['role_id'=>Role::where('slug','trainer')->value('id'),'status'=>'active']);
        $trainer=Trainer::firstOrCreate(['organization_id'=>$org->id,'trainer_number'=>'TRN-0001'], ['user_id'=>$trainerUser->id,'specialization'=>'Backend Engineering','email'=>$trainerUser->email,'status'=>'active']);
        $trainer->courses()->syncWithoutDetaching([$course->id]);
        $batch=Batch::firstOrCreate(['organization_id'=>$org->id,'code'=>'2026-09-A'], ['course_id'=>$course->id,'name'=>'Laravel Fundamentals — September 2026','trainer_id'=>$trainer->id,'start_date'=>now()->startOfMonth(),'end_date'=>now()->startOfMonth()->addDays(20),'capacity'=>30,'status'=>'active','location'=>'Abu Dhabi']);
        $batch->learners()->syncWithoutDetaching([$learner->id]);
    }
}
