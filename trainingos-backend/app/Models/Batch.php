<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Batch extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','course_id','name','code','trainer_id','start_date','end_date','capacity','status','location','description'];
    protected function casts(): array { return ['start_date'=>'date','end_date'=>'date','capacity'=>'integer']; }
    public function course(): BelongsTo { return $this->belongsTo(Course::class); }
    public function trainer(): BelongsTo { return $this->belongsTo(Trainer::class); }
    public function learners(): BelongsToMany { return $this->belongsToMany(Learner::class,'batch_learners')->withTimestamps(); }
    public function trainers(): BelongsToMany { return $this->belongsToMany(Trainer::class,'batch_trainers')->withTimestamps(); }
    public function sessions() { return $this->hasMany(TrainingSession::class); }
}
