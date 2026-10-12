<?php
namespace Tests\Feature;
use App\Models\Organization; use App\Models\Role; use App\Models\User; use Laravel\Sanctum\Sanctum; use Tests\TestCase; use Illuminate\Foundation\Testing\RefreshDatabase;
class TenantIsolationTest extends TestCase
{
 use RefreshDatabase;
 public function test_user_cannot_access_other_organization_resources():void{$a=Organization::create(['name'=>'A','slug'=>'a','status'=>'active','timezone'=>'UTC','currency'=>'AED']);$b=Organization::create(['name'=>'B','slug'=>'b','status'=>'active','timezone'=>'UTC','currency'=>'AED']);$role=Role::create(['name'=>'Owner','slug'=>'owner','system'=>true]);$u=User::factory()->create(['active_organization_id'=>$a->id]);$a->users()->attach($u->id,['role_id'=>$role->id,'status'=>'active']);Sanctum::actingAs($u);$r=$this->getJson('/api/v1/organizations/current',['X-Organization-Id'=>$b->id]);$r->assertForbidden();}
}
