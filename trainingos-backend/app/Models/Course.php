<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Course extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','code','name','slug','category','description','duration_hours','level','prerequisites','status','published_at'];
    protected function casts(): array { return ['duration_hours'=>'integer','published_at'=>'datetime']; }
    public function modules() { return $this->hasMany(CourseModule::class)->orderBy('sort_order'); }
    public function materials() { return $this->hasMany(CourseMaterial::class); }
    public function trainers(): BelongsToMany { return $this->belongsToMany(Trainer::class,'course_trainers')->withTimestamps(); }
    public function batches() { return $this->hasMany(Batch::class); }
}
