<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use App\Support\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
class AuthController extends Controller
{
 use ApiResponder;
 public function register(RegisterRequest $request){
  $result=DB::transaction(function()use($request){
   $org=Organization::create(['name'=>$request->organization_name,'slug'=>Str::slug($request->organization_name).'-'.Str::lower(Str::random(6)),'country'=>$request->country,'timezone'=>$request->timezone ?: 'UTC','currency'=>$request->currency ?: 'AED','status'=>'active']);
   $user=User::create(['name'=>$request->name,'email'=>$request->email,'password'=>$request->password,'active_organization_id'=>$org->id]);
   $role=Role::where('slug','owner')->firstOrFail(); $org->users()->attach($user->id,['role_id'=>$role->id,'status'=>'active']);
   return [$user,$org];
  });
  [$user,$org]=$result; Auth::guard('web')->login($user); $request->session()->regenerate(); $token=$user->createToken('trainingos-spa',['*'])->plainTextToken;
  return $this->ok(['token'=>$token,'user'=>$user,'organization'=>$org],'Registration successful',201);
 }
 public function login(AuthLoginRequest $request){
  $user=User::where('email',$request->email)->first();
  if(!$user || !Hash::check($request->password,$user->password)) throw ValidationException::withMessages(['email'=>['The provided credentials are incorrect.']]);
  Auth::guard('web')->login($user); $request->session()->regenerate(); $token=$user->createToken('trainingos-spa',['*'])->plainTextToken;
  $org=$user->organizations()->where('status','active')->first();
  if($org && !$user->active_organization_id) {$user->forceFill(['active_organization_id'=>$org->id])->save();}
  return $this->ok(['token'=>$token,'user'=>$user,'organization'=>$org],'Login successful');
 }

 public function forgotPassword(Request $request){
  $request->validate(['email'=>'required|email']);
  $status=Password::sendResetLink(['email'=>$request->email]);
  return $this->ok(null,__($status));
 }
 public function resetPassword(Request $request){
  $request->validate(['token'=>'required|string','email'=>'required|email','password'=>'required|string|min:8|confirmed']);
  $status=Password::reset($request->only('email','password','password_confirmation','token'),function($user,$password){$user->forceFill(['password'=>$password])->save();$user->tokens()->delete();});
  if($status!==Password::PASSWORD_RESET){throw ValidationException::withMessages(['email'=>[__($status)]]);}
  return $this->ok(null,__($status));
 }

 public function me(Request $request){$user=$request->user(); return $this->ok(['user'=>$user->load('organizations')]);}
 public function logout(Request $request){$request->user()->currentAccessToken()?->delete(); Auth::guard('web')->logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return $this->ok(null,'Logged out');}
 public function switchOrganization(Request $request){$request->validate(['organization_id'=>'required|integer']); $org=$request->user()->organizations()->whereKey($request->organization_id)->firstOrFail(); $request->user()->update(['active_organization_id'=>$org->id]); return $this->ok(['organization'=>$org],'Organization switched');}
}
