<?php
namespace App\Http\Controllers\Api;
use App\Models\AttendanceRecord;
use App\Models\Batch;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Learner;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
class DashboardController extends BaseTenantController
{
 public function __invoke(Request $request){
  $org=$this->orgId();
  $activeLearners=Learner::where('status','active')->count();
  $attendanceTotal=AttendanceRecord::count(); $attendanceGood=$attendanceTotal?AttendanceRecord::whereIn('status',['present','late'])->count():0;
  return $this->ok([
   'stats'=>['active_learners'=>$activeLearners,'active_courses'=>Course::whereIn('status',['active','published'])->count(),'active_batches'=>Batch::whereIn('status',['planned','active'])->count(),'completion_rate'=>round((float)($attendanceGood/ max(1,$attendanceTotal))*100,1)],
   'today_sessions'=>TrainingSession::whereDate('starts_at',today())->orderBy('starts_at')->with('batch')->get(),
   'upcoming_certificates'=>Certificate::where('status','pending')->latest('id')->with(['learner','course'])->limit(10)->get(),
  ]);
 }
}
