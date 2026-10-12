<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class CourseRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['code'=>'required|string|max:50','name'=>'required|string|max:180','category'=>'nullable|string|max:100','description'=>'nullable|string','duration_hours'=>'required|integer|min:0|max:10000','level'=>'nullable|string|max:50','prerequisites'=>'nullable|string','status'=>'nullable|in:draft,active,archived'];} }
