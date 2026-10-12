<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class AssessmentAttempt extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','assessment_id','learner_id','score','percentage','grade','result','comments','submitted_at'];
    protected function casts(): array { return ['score'=>'decimal:2','percentage'=>'decimal:2','submitted_at'=>'datetime']; }
    public function answers(){return $this->hasMany(AssessmentAnswer::class);}
}
