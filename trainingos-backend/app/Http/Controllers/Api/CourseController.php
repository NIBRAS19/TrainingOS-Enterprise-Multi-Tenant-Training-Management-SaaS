<?php
namespace App\Http\Controllers\Api;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class CourseController extends BaseTenantController
{
 public function index(Request $r){$q=Course::query()->withCount(['modules','batches']);if($r->filled('search'))$q->where(function($x)use($r){$x->where('name','like','%'.$r->search.'%')->orWhere('code','like','%'.$r->search.'%');});if($r->filled('status'))$q->where('status',$r->status);return $this->paginated($q->latest()->paginate(min((int)$r->input('per_page',20),100)));}
 public function store(CourseRequest $r){$d=$r->validated();$d['slug']=Str::slug($d['name']).'-'.Str::lower(Str::random(5));$d['published_at']=($d['status']??'draft')==='active'?now():null;$c=Course::create($d);$this->audit->log('created','course',$c->id);return $this->ok($c,'Course created',201);}
 public function show(Course $course){return $this->ok($course->load(['modules','materials','trainers','batches.trainer']));}
 public function update(CourseRequest $r,Course $course){$d=$r->validated();if(isset($d['name'])&&$d['name']!==$course->name)$d['slug']=Str::slug($d['name']).'-'.Str::lower(Str::random(5));if(($d['status']??$course->status)==='active'&&!$course->published_at)$d['published_at']=now();$course->update($d);$this->audit->log('updated','course',$course->id);return $this->ok($course,'Course updated');}
 public function destroy(Course $course){$course->update(['status'=>'archived']);$this->audit->log('archived','course',$course->id);return $this->ok(null,'Course archived');}
 public function modules(Course $course){return $this->ok($course->modules);}
 public function storeModule(Request $r,Course $course){$d=$r->validate(['title'=>'required|string|max:180','description'=>'nullable|string','sort_order'=>'nullable|integer|min:0','duration_minutes'=>'nullable|integer|min:0','status'=>'nullable|in:active,draft']);$m=CourseModule::create(array_merge($d,['course_id'=>$course->id]));return $this->ok($m,'Module created',201);}
 public function destroyModule(Course $course,CourseModule $module){abort_unless($module->course_id===$course->id,404);$module->delete();return $this->ok(null,'Module deleted');}
 public function storeMaterial(Request $r,Course $course){$r->validate(['title'=>'required|string|max:180','file'=>'required|file|max:20480']);$file=$r->file('file');$path=$file->store('organizations/'.$this->orgId().'/courses/'.$course->id,'local');$m=CourseMaterial::create(['course_id'=>$course->id,'title'=>$r->title,'type'=>'file','path'=>$path,'mime_type'=>$file->getMimeType(),'size'=>$file->getSize(),'is_public'=>false]);return $this->ok($m,'Material uploaded',201);}
 public function downloadMaterial(Course $course,CourseMaterial $material){abort_unless($material->course_id===$course->id,404);return Storage::disk('local')->download($material->path,$material->title);}
 public function syncTrainers(Request $r,Course $course){$r->validate(['trainer_ids'=>'array','trainer_ids.*'=>'integer|exists:trainers,id']);$course->trainers()->sync($r->trainer_ids??[]);return $this->ok($course->load('trainers'),'Course trainers updated');}
}
