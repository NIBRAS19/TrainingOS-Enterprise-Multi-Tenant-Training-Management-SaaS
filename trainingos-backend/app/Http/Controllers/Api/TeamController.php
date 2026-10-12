<?php
namespace App\Http\Controllers\Api;
use App\Http\Requests\TeamMemberRequest;
use App\Models\Invitation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class TeamController extends BaseTenantController
{
 public function index(){return $this->ok($this->tenant->organization()->users()->withPivot('role_id','status')->get()->map(fn($u)=>$u->setAttribute('role',Role::find($u->pivot->role_id)?->slug)));}
 public function store(TeamMemberRequest $r){$role=Role::where('slug',$r->role)->firstOrFail();$raw=Str::password(16);$user=User::create(['name'=>$r->name,'email'=>$r->email,'password'=>Hash::make($raw),'active_organization_id'=>$this->orgId()]);$this->tenant->organization()->users()->attach($user->id,['role_id'=>$role->id,'status'=>'active']);return $this->ok(['user'=>$user,'temporary_password'=>$raw],'Team member created',201);}
 public function update(Request $r,User $user){$role=Role::where('slug',$r->role)->firstOrFail();$membership=$this->tenant->organization()->users()->whereKey($user->id)->firstOrFail();$membership->pivot->update(['role_id'=>$role->id,'status'=>$r->input('status','active')]);$user->update($r->only('name','avatar'));return $this->ok($user,'Team member updated');}
 public function remove(User $user){$this->tenant->organization()->users()->detach($user->id);return $this->ok(null,'Team member removed');}
 public function roles(){return $this->ok(Role::orderBy('name')->get(['id','name','slug','description']));}
 public function permissions(){return $this->ok(Role::with('permissions')->get());}
}
