<?php
namespace App\Http\Controllers\Api;
use App\Http\Requests\LearnerRequest;
use App\Models\Learner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class LearnerController extends BaseTenantController
{
 public function index(Request $r){$q=Learner::query()->withCount('batches'); if($r->filled('search')){$s=$r->string('search');$q->where(function($x)use($s){$x->where('first_name','like',"%$s%")->orWhere('last_name','like',"%$s%")->orWhere('email','like',"%$s%")->orWhere('learner_number','like',"%$s%");});} if($r->filled('status'))$q->where('status',$r->status); return $this->paginated($q->latest()->paginate(min((int)$r->input('per_page',20),100)));}
 public function store(LearnerRequest $r){$id='LRN-'.strtoupper(Str::random(8));$learner=Learner::create(array_merge($r->validated(),['learner_number'=>$id]));$this->audit->log('created','learner',$learner->id);return $this->ok($learner,'Learner created',201);}
 public function show(Learner $learner){return $this->ok($learner->load(['batches.course','attendanceRecords','user']));}
 public function update(LearnerRequest $r,Learner $learner){$learner->update($r->validated());$this->audit->log('updated','learner',$learner->id);return $this->ok($learner,'Learner updated');}
 public function destroy(Learner $learner){$learner->update(['status'=>'inactive']);$this->audit->log('archived','learner',$learner->id);return $this->ok(null,'Learner archived');}
 public function attendance(Learner $learner){return $this->ok(['percentage'=>$learner->attendance_percentage,'records'=>$learner->attendanceRecords()->latest('marked_at')->get()]);}
 public function enroll(Request $r,Learner $learner){$r->validate(['batch_id'=>'required|integer']);$batch=$this->tenant->organization()->batches()->whereKey($r->batch_id)->firstOrFail();$batch->learners()->syncWithoutDetaching([$learner->id]);$this->audit->log('enrolled','learner',$learner->id,['batch_id'=>$batch->id]);return $this->ok($batch->load('learners'),'Learner enrolled');}
}
