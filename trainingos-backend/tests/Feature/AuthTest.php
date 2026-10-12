<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class AuthTest extends TestCase
{
 use RefreshDatabase;
 public function test_registration_returns_token():void{$r=$this->postJson('/api/v1/auth/register',['name'=>'Test User','email'=>'test@example.com','password'=>'password123','password_confirmation'=>'password123','organization_name'=>'Test Academy']);$r->assertCreated()->assertJsonPath('data.user.email','test@example.com');}
}
