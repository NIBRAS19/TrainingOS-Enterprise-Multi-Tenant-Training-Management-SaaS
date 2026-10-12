<?php
namespace App\Http\Controllers\Api;
use App\Models\Certificate;
use App\Models\CertificateTemplate;
use App\Models\Learner;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class CertificateController extends BaseTenantController
{
 public function index(Request $r){$q=Certificate::query()->with(['learner','course','batch']);if($r->filled('status'))$q->where('status',$r->status);return $this->paginated($q->latest()->paginate(min((int)$r->input('per_page',20),100)));}
 public function templates(){return $this->ok(CertificateTemplate::latest()->get());}
 public function storeTemplate(Request $r){$d=$r->validate(['name'=>'required|string|max:120','html'=>'required|string','paper_size'=>'nullable|string','orientation'=>'nullable|in:portrait,landscape','status'=>'nullable|in:active,inactive','is_default'=>'boolean']);if($d['is_default']??false)CertificateTemplate::where('organization_id',$this->orgId())->update(['is_default'=>false]);$t=CertificateTemplate::create($d);return $this->ok($t,'Template created',201);}
 public function generate(Request $r){$d=$r->validate(['learner_id'=>'required|integer|exists:learners,id','course_id'=>'required|integer|exists:courses,id','batch_id'=>'nullable|integer|exists:batches,id','certificate_template_id'=>'nullable|integer|exists:certificate_templates,id','issue_date'=>'nullable|date']);$number=($this->tenant->organization()->settings['certificate_prefix']??'CERT').'-'.now()->format('Y').'-'.strtoupper(Str::random(8));$t=$d['certificate_template_id']??CertificateTemplate::where('organization_id',$this->orgId())->where('is_default',true)->value('id');$c=Certificate::create(['certificate_template_id'=>$t,'learner_id'=>$d['learner_id'],'course_id'=>$d['course_id'],'batch_id'=>$d['batch_id']??null,'number'=>$number,'issue_date'=>$d['issue_date']??today(),'status'=>'issued']);$this->audit->log('issued','certificate',$c->id,['number'=>$c->number]);return $this->ok($c->load(['learner','course','batch','template']),'Certificate issued',201);}
 public function show(Certificate $certificate){return $this->ok($certificate->load(['learner','course','batch','template']));}
 public function revoke(Request $r,Certificate $certificate){$r->validate(['reason'=>'required|string|max:1000']);$certificate->update(['status'=>'revoked','revoked_at'=>now(),'revoked_reason'=>$r->reason]);$this->audit->log('revoked','certificate',$certificate->id);return $this->ok($certificate,'Certificate revoked');}
 public function download(Certificate $certificate){$verify=url('/api/v1/public/certificates/'.$certificate->number);$qrSvg=QrCode::format('svg')->size(100)->generate($verify);$pdf=Pdf::loadView('certificates.certificate',['certificate'=>$certificate->load(['learner','course','batch']),'verificationUrl'=>$verify,'qrSvg'=>$qrSvg])->setPaper(strtolower($certificate->template?->paper_size ?? 'a4'),$certificate->template?->orientation ?? 'landscape');return $pdf->download($certificate->number.'.pdf');}
 public function verify(string $number){$certificate=Certificate::withoutGlobalScope('tenant')->where('number',$number)->with(['learner','course','organization'])->first();abort_unless($certificate,404,'Certificate not found.');return $this->ok(['valid'=>$certificate->status==='issued','certificate'=>$certificate]);}
}
