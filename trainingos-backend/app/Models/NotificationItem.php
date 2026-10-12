<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class NotificationItem extends Model
{
    use BelongsToTenant;
    protected $table='notification_items';
    protected $fillable=['organization_id','user_id','title','description','type','read_at','data'];
    protected function casts(): array { return ['read_at'=>'datetime','data'=>'array']; }
}
