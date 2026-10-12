<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class AttendanceRecord extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','session_id','learner_id','status','notes','marked_by','marked_at'];
    protected function casts(): array { return ['marked_at'=>'datetime']; }
}
