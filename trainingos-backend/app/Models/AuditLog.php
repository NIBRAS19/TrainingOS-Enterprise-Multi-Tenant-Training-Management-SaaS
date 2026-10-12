<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class AuditLog extends Model
{
    use BelongsToTenant;
    public $timestamps=false;
    protected $fillable=['organization_id','user_id','action','resource','resource_id','metadata','ip_address','user_agent','created_at'];
    protected function casts(): array { return ['metadata'=>'array','created_at'=>'datetime']; }
}
