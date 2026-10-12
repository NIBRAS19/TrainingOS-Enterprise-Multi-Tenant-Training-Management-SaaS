<?php
namespace App\Http\Controllers\Api;
use App\Http\Requests\DocumentUploadRequest;
use App\Models\Document;
use App\Models\DocumentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class DocumentController extends BaseTenantController
{
 public function index(Request $r){$q=Document::query()->with('versions');if($r->filled('category'))$q->where('category',$r->category);if($r->filled('search'))$q->where('title','like','%'.$r->search.'%');return $this->paginated($q->latest()->paginate(min((int)$r->input('per_page',20),100)));}
 public function store(DocumentUploadRequest $r){$file=$r->file('file');$doc=Document::create(['title'=>$r->title,'category'=>$r->category??'general','visibility'=>$r->visibility??'private','owner_type'=>$r->owner_type,'owner_id'=>$r->owner_id]);$version=DocumentVersion::create(['document_id'=>$doc->id,'version'=>1,'path'=>$file->store('organizations/'.$this->orgId().'/documents','local'),'mime_type'=>$file->getMimeType(),'size'=>$file->getSize(),'uploaded_by'=>$r->user()->id,'checksum'=>hash_file('sha256',$file->getRealPath())]);$doc->update(['current_version_id'=>$version->id]);return $this->ok($doc->fresh()->load('versions'),'Document uploaded',201);}
 public function show(Document $document){return $this->ok($document->load('versions'));}
 public function download(Document $document,DocumentVersion $version){abort_unless($version->document_id===$document->id,404);abort_unless(Storage::disk('local')->exists($version->path),404);return Storage::disk('local')->download($version->path,$document->title);}
 public function destroy(Document $document){foreach($document->versions as $v){Storage::disk('local')->delete($v->path);} $document->delete();return $this->ok(null,'Document deleted');}
}
