<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Learner extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','user_id','learner_number','first_name','last_name','email','phone','date_of_birth','gender','company','job_title','address','city','country','emergency_contact_name','emergency_contact_phone','emergency_contact_relationship','status','notes'];
    protected function casts(): array { return ['date_of_birth'=>'date']; }
    protected $appends=['name','attendance_percentage'];
    public function getNameAttribute(): string { return trim($this->first_name.' '.$this->last_name); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function batches(): BelongsToMany { return $this->belongsToMany(Batch::class,'batch_learners')->withTimestamps(); }
    public function attendanceRecords() { return $this->hasMany(AttendanceRecord::class); }
    public function getAttendancePercentageAttribute(): float { $total=$this->attendanceRecords()->count(); if(!$total)return 0.0; $present=$this->attendanceRecords()->whereIn('status',['present','late'])->count(); return round(($present/$total)*100,1); }
}
