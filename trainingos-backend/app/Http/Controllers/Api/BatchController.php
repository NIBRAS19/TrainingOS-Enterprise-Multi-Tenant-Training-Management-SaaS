<?php
namespace App\Http\Controllers\Api;
use App\Http\Requests\BatchRequest;
use App\Http\Requests\SessionRequest;
use App\Models\Batch;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class BatchController extends BaseTenantController
{
 public function index(Request $r){$q=Batch::query()->with(['course','trainer.user'])->withCount('learners');if($r->filled('status'))$q->where('status',$r->status);if($r->filled('course_id'))$q->where('course_id',$r->course_id);return $this->paginated($q->latest()->paginate(min((int)$r->input('per_page',20),100)));}
 public function store(BatchRequest $r){$d=$r->validated();$batch=Batch::create($d);$batch->code=$d['code']?:'BAT-'.strtoupper(Str::random(6));$batch->save();$this->audit->log('created','batch',$batch->id);return $this->ok($batch->load(['course','trainer']),'Batch created',201);}
 public function show(Batch $batch){return $this->ok($batch->load(['course','trainer.user','learners','sessions']));}
 public function update(BatchRequest $r,Batch $batch){$batch->update($r->validated());$this->audit->log('updated','batch',$batch->id);return $this->ok($batch->load(['course','trainer']),'Batch updated');}
 public function destroy(Batch $batch){$batch->update(['status'=>'cancelled']);$this->audit->log('cancelled','batch',$batch->id);return $this->ok(null,'Batch cancelled');}
 public function enroll(Request $r,Batch $batch){$r->validate(['learner_ids'=>'required|array','learner_ids.*'=>'integer|exists:learners,id']);$capacity=$batch->capacity; $current=$batch->learners()->count();$incoming=count($r->learner_ids);abort_if($current+$incoming>$capacity,422,'Batch capacity exceeded.');$batch->learners()->syncWithoutDetaching($r->learner_ids);return $this->ok($batch->load('learners'),'Learners enrolled');}
 public function unenroll(Request $r,Batch $batch,int $learnerId){$batch->learners()->detach($learnerId);return $this->ok(null,'Learner removed from batch');}
 public function sessions(Batch $batch){return $this->ok($batch->sessions()->orderBy('starts_at')->get());}
 public function storeSession(SessionRequest $r,Batch $batch){$d=$r->validated();$s=TrainingSession::create($d);return $this->ok($s,'Session created',201);}
 public function updateSession(SessionRequest $r,Batch $batch,TrainingSession $session){abort_unless($session->batch_id===$batch->id,404);$session->update($r->validated());return $this->ok($session,'Session updated');}
 public function destroySession(Batch $batch,TrainingSession $session){abort_unless($session->batch_id===$batch->id,404);$session->delete();return $this->ok(null,'Session deleted');}
}
