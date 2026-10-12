<?php
namespace App\Http\Controllers\Api;
use App\Models\Certificate;
use App\Support\ApiResponder;
use Illuminate\Routing\Controller;
class PublicCertificateController extends Controller
{
 use ApiResponder;
 public function show(string $number){$c=Certificate::withoutGlobalScope('tenant')->where('number',$number)->with(['learner','course','organization'])->first();abort_unless($c,404,'Certificate not found.');return $this->ok(['valid'=>$c->status==='issued','certificate'=>['number'=>$c->number,'status'=>$c->status,'issue_date'=>$c->issue_date,'learner'=>$c->learner?->name,'course'=>$c->course?->name,'organization'=>$c->organization?->name]]);}
}
