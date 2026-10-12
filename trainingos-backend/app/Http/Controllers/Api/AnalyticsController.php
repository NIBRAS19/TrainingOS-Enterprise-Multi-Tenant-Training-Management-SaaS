<?php
namespace App\Http\Controllers\Api;
use App\Models\AttendanceRecord;
use App\Models\Batch;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Learner;
class AnalyticsController extends BaseTenantController
{
 public function __invoke(){return $this->ok([
  'kpis'=>['learner_growth'=>$this->growth(Learner::class),'completion_rate'=>$this->completionRate(),'attendance_rate'=>$this->attendanceRate(),'certificates_issued'=>Certificate::where('status','issued')->count(),'active_batches'=>Batch::where('status','active')->count()],
  'course_breakdown'=>Course::withCount('batches')->withCount(['modules'])->orderByDesc('batches_count')->get(['id','name','code']),
  'certificate_breakdown'=>Certificate::selectRaw('status,COUNT(*) total')->groupBy('status')->get(),
 ]);}
 private function growth(string $model): float { $current=$model::where('created_at','>=',now()->subDays(30))->count();$prev=$model::whereBetween('created_at',[now()->subDays(60),now()->subDays(30)])->count();return $prev?round((($current-$prev)/$prev)*100,1):($current?100:0);}
 private function attendanceRate():float{$t=AttendanceRecord::count();return $t?round((AttendanceRecord::whereIn('status',['present','late'])->count()/$t)*100,1):0;}
 private function completionRate():float{$t=Certificate::count();return $t?round((Certificate::where('status','issued')->count()/$t)*100,1):0;}
}
