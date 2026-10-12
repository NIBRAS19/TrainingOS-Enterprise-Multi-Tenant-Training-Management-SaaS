<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class Invitation extends Model
{
    use BelongsToTenant;
    protected $table='organization_invitations';
    protected $fillable=['organization_id','email','role_id','token_hash','expires_at','accepted_at','invited_by'];
    protected function casts(): array { return ['expires_at'=>'datetime','accepted_at'=>'datetime']; }
    public function role(){return $this->belongsTo(Role::class);}
}
