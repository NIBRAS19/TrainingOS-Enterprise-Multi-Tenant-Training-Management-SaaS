<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AttendanceRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['records'=>'required|array|min:1','records.*.learner_id'=>'required|integer|exists:learners,id','records.*.status'=>'required|in:present,absent,late,excused','records.*.notes'=>'nullable|string|max:500'];} }
