<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class SessionRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['batch_id'=>'required|integer|exists:batches,id','title'=>'required|string|max:180','starts_at'=>'required|date','ends_at'=>'required|date|after:starts_at','location'=>'nullable|string|max:255','status'=>'nullable|in:scheduled,completed,cancelled','notes'=>'nullable|string'];} }
