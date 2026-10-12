<?php
namespace App\Http\Controllers\Api;
use App\Http\Requests\AttendanceRequest;
use App\Models\AttendanceRecord;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
class AttendanceController extends BaseTenantController
{
 public function index(Request $r){$q=AttendanceRecord::query()->with(['learner','session.batch']);if($r->filled('session_id'))$q->where('session_id',$r->session_id);if($r->filled('learner_id'))$q->where('learner_id',$r->learner_id);return $this->paginated($q->latest()->paginate(min((int)$r->input('per_page',100),200)));}
 public function store(AttendanceRequest $r,TrainingSession $session){$batchLearners=$session->batch->learners()->pluck('learners.id')->all();foreach($r->records as $record){abort_unless(in_array((int)$record['learner_id'],$batchLearners,true),422,'Learner is not enrolled in this batch.');AttendanceRecord::updateOrCreate(['session_id'=>$session->id,'learner_id'=>$record['learner_id']],['organization_id'=>$this->orgId(),'status'=>$record['status'],'notes'=>$record['notes']??null,'marked_by'=>$r->user()->id,'marked_at'=>now()]);} $this->audit->log('recorded','attendance',$session->id,['count'=>count($r->records)]);return $this->ok($session->load('batch'),'Attendance saved');}
 public function session(TrainingSession $session){return $this->ok(['session'=>$session->load(['batch.learners','batch.course','batch.trainer']),'attendance'=>AttendanceRecord::where('session_id',$session->id)->with('learner')->get()]);}
}
