<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Trainer extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','user_id','trainer_number','bio','specialization','email','phone','status'];
    protected $appends=['name'];
    public function getNameAttribute(): string { return optional($this->user)->name ?? ($this->trainer_number ?? 'Trainer'); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function courses(): BelongsToMany { return $this->belongsToMany(Course::class,'course_trainers')->withTimestamps(); }
    public function batches() { return $this->hasMany(Batch::class); }
}
