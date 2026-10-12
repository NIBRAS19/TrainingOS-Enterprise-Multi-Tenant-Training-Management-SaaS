<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class TrainingSession extends Model
{
    use BelongsToTenant;
    protected $table='training_sessions';
    protected $fillable=['organization_id','batch_id','title','starts_at','ends_at','location','status','notes'];
    protected function casts(): array { return ['starts_at'=>'datetime','ends_at'=>'datetime']; }
}
