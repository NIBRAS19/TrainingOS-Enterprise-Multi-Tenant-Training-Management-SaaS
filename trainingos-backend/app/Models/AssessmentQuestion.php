<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class AssessmentQuestion extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','assessment_id','question','type','options','correct_answer','points','sort_order'];
    protected function casts(): array { return ['options'=>'array','points'=>'decimal:2']; }
}
