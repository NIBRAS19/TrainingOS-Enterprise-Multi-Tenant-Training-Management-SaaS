<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class BatchRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['course_id'=>'required|integer|exists:courses,id','name'=>'required|string|max:180','code'=>'required|string|max:50','trainer_id'=>'nullable|integer|exists:trainers,id','start_date'=>'required|date','end_date'=>'required|date|after_or_equal:start_date','capacity'=>'required|integer|min:1|max:100000','status'=>'nullable|in:planned,active,completed,cancelled','location'=>'nullable|string|max:255','description'=>'nullable|string'];} }
