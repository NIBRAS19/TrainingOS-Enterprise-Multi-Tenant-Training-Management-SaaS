<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class RegisterRequest extends FormRequest { public function authorize(): bool{return true;} public function rules():array{return ['name'=>['required','string','max:120'],'email'=>['required','email','max:255','unique:users,email'],'password'=>['required','string','min:8','confirmed'],'organization_name'=>['required','string','max:160'],'country'=>['nullable','string','max:100'],'timezone'=>['nullable','string','max:80'],'currency'=>['nullable','string','max:8']];} }
