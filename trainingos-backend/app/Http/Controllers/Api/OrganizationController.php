<?php
namespace App\Http\Controllers\Api;
use App\Models\Organization;
use Illuminate\Http\Request;
class OrganizationController extends BaseTenantController
{
 public function current(){return $this->ok($this->tenant->organization()->loadCount('users'));}
 public function index(Request $r){return $this->ok($r->user()->organizations()->get());}
 public function switch(Request $r){$r->validate(['organization_id'=>'required|integer']);$org=$r->user()->organizations()->whereKey($r->organization_id)->firstOrFail();$r->user()->update(['active_organization_id'=>$org->id]);return $this->ok($org,'Active organization changed');}
}
