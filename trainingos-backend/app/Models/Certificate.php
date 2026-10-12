<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class Certificate extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','certificate_template_id','learner_id','course_id','batch_id','number','issue_date','status','metadata','revoked_at','revoked_reason'];
    protected function casts(): array { return ['issue_date'=>'date','metadata'=>'array','revoked_at'=>'datetime']; }
    public function learner(){return $this->belongsTo(Learner::class);}
    public function course(){return $this->belongsTo(Course::class);}
    public function batch(){return $this->belongsTo(Batch::class);}
    public function template(){return $this->belongsTo(CertificateTemplate::class,'certificate_template_id');}
}
