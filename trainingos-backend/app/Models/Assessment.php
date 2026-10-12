<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class Assessment extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','course_id','batch_id','title','type','date','maximum_score','pass_percentage','status','instructions'];
    protected function casts(): array { return ['date'=>'date','maximum_score'=>'decimal:2','pass_percentage'=>'decimal:2']; }
    public function questions(){return $this->hasMany(AssessmentQuestion::class)->orderBy('sort_order');}
    public function attempts(){return $this->hasMany(AssessmentAttempt::class);}
}
