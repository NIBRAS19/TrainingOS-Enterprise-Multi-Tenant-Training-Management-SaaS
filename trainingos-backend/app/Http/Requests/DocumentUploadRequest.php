<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class DocumentUploadRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['title'=>'required|string|max:180','category'=>'nullable|string|max:80','visibility'=>'nullable|in:private,organization','owner_type'=>'nullable|string|max:120','owner_id'=>'nullable|integer','file'=>'required|file|max:10240'];} }
