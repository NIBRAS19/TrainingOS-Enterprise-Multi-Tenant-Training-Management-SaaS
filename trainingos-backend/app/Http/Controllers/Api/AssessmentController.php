<?php
namespace App\Http\Controllers\Api;
use App\Http\Requests\AssessmentRequest;
use App\Models\Assessment;
use App\Models\AssessmentAttempt;
use Illuminate\Http\Request;
class AssessmentController extends BaseTenantController
{
 public function index(Request $r){$q=Assessment::query()->with(['course','batch'])->withCount('attempts');if($r->filled('course_id'))$q->where('course_id',$r->course_id);return $this->paginated($q->latest()->paginate(min((int)$r->input('per_page',20),100)));}
 public function store(AssessmentRequest $r){$d=$r->validated();$questions=$d['questions']??[];unset($d['questions']);$a=Assessment::create($d);foreach($questions as $i=>$q){$a->questions()->create(array_merge($q,['organization_id'=>$this->orgId(),'sort_order'=>$q['sort_order']??$i+1]));}return $this->ok($a->load('questions'),'Assessment created',201);}
 public function show(Assessment $assessment){return $this->ok($assessment->load(['course','batch','questions','attempts']));}
 public function update(AssessmentRequest $r,Assessment $assessment){$d=$r->validated();$questions=$d['questions']??null;unset($d['questions']);$assessment->update($d);if(is_array($questions)){$assessment->questions()->delete();foreach($questions as $i=>$q)$assessment->questions()->create(array_merge($q,['organization_id'=>$this->orgId(),'sort_order'=>$q['sort_order']??$i+1]));}return $this->ok($assessment->load('questions'),'Assessment updated');}
 public function results(Assessment $assessment){return $this->ok($assessment->attempts()->with('learner')->latest()->get());}
 public function submit(Request $r,Assessment $assessment){$d=$r->validate(['learner_id'=>'required|integer|exists:learners,id','score'=>'required|numeric|min:0','comments'=>'nullable|string']);$percentage=round(($d['score']/max(0.01,(float)$assessment->maximum_score))*100,2);$result=$percentage >= (float)$assessment->pass_percentage?'pass':'fail';$attempt=AssessmentAttempt::updateOrCreate(['assessment_id'=>$assessment->id,'learner_id'=>$d['learner_id']],['organization_id'=>$this->orgId(),'score'=>$d['score'],'percentage'=>$percentage,'result'=>$result,'comments'=>$d['comments']??null,'submitted_at'=>now()]);return $this->ok($attempt,'Assessment result saved',201);}
}
