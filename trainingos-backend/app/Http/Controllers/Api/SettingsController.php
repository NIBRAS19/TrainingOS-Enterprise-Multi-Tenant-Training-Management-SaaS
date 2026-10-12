<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class SettingsController extends BaseTenantController
{
 public function show(){return $this->ok($this->tenant->organization());}
 public function update(Request $r){$d=$r->validate(['name'=>'sometimes|string|max:160','country'=>'nullable|string|max:100','timezone'=>'nullable|string|max:80','currency'=>'nullable|string|max:8','primary_color'=>'nullable|string|max:20','settings'=>'nullable|array']);$this->tenant->organization()->update($d);return $this->ok($this->tenant->organization(),'Settings updated');}
 public function branding(Request $r){$r->validate(['logo'=>'nullable|image|max:4096']);$org=$this->tenant->organization();if($r->hasFile('logo')){$path=$r->file('logo')->store('organizations/'.$org->id.'/branding','public');$org->update(['logo_path'=>$path]);}return $this->ok($org->fresh(),'Branding updated');}
 public function profile(Request $r){$d=$r->validate(['name'=>'required|string|max:120','avatar'=>'nullable|image|max:2048']);$u=$r->user();$u->name=$d['name'];if($r->hasFile('avatar'))$u->avatar=$r->file('avatar')->store('users/'.$u->id,'public');$u->save();return $this->ok($u,'Profile updated');}
}
