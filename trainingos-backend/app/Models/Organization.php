<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Organization extends Model
{
    protected $fillable=['name','slug','logo_path','primary_color','country','timezone','currency','status','settings'];
    protected function casts(): array { return ['settings'=>'array']; }
    public function users(): BelongsToMany { return $this->belongsToMany(User::class)->withPivot(['role_id','status'])->withTimestamps(); }
    public function learners(): HasMany { return $this->hasMany(Learner::class); }
    public function trainers(): HasMany { return $this->hasMany(Trainer::class); }
    public function courses(): HasMany { return $this->hasMany(Course::class); }
    public function batches(): HasMany { return $this->hasMany(Batch::class); }
}
