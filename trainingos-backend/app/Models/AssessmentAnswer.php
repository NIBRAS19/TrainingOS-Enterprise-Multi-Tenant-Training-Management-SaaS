<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class AssessmentAnswer extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','attempt_id','question_id','answer','points_awarded','is_correct'];
    protected function casts(): array { return ['points_awarded'=>'decimal:2','is_correct'=>'boolean']; }
}
