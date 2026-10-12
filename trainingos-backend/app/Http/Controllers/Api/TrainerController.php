<?php
namespace App\Http\Controllers\Api;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class TrainerController extends BaseTenantController
{
 public function index(Request $r){$q=Trainer::query()->withCount(['courses','batches']); if($r->filled('search'))$q->where('specialization','like','%'.$r->search.'%')->orWhereHas('user',fn($x)=>$x->where('name','like','%'.$r->search.'%')); return $this->paginated($q->latest()->paginate(min((int)$r->input('per_page',20),100)));}
 public function store(Request $r){$d=$r->validate(['user_id'=>'nullable|integer|exists:users,id','name'=>'nullable|string|max:120','email'=>'nullable|email','phone'=>'nullable|string','specialization'=>'nullable|string|max:180','bio'=>'nullable|string','status'=>'nullable|in:active,inactive']);$trainer=Trainer::create(array_merge($d,['trainer_number'=>'TRN-'.strtoupper(Str::random(8))]));$this->audit->log('created','trainer',$trainer->id);return $this->ok($trainer->load('user'),'Trainer created',201);}
 public function show(Trainer $trainer){return $this->ok($trainer->load(['user','courses','batches.course']));}
 public function update(Request $r,Trainer $trainer){$trainer->update($r->validate(['specialization'=>'nullable|string|max:180','bio'=>'nullable|string','email'=>'nullable|email','phone'=>'nullable|string','status'=>'nullable|in:active,inactive']));$this->audit->log('updated','trainer',$trainer->id);return $this->ok($trainer->load('user'),'Trainer updated');}
 public function destroy(Trainer $trainer){$trainer->update(['status'=>'inactive']);$this->audit->log('archived','trainer',$trainer->id);return $this->ok(null,'Trainer archived');}
}
