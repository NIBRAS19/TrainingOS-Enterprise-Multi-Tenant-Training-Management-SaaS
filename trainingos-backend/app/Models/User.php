<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['name','email','password','active_organization_id','avatar'];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed']; }
    public function organizations(): BelongsToMany { return $this->belongsToMany(Organization::class)->withPivot(['role_id','status'])->withTimestamps(); }
    public function roleFor(int $organizationId): ?Role { $membership = $this->organizations()->whereKey($organizationId)->first()?->pivot; return $membership?->role_id ? Role::find($membership->role_id) : null; }
    public function hasPermission(int $organizationId, string $permission): bool { return (bool) optional($this->roleFor($organizationId))->permissions()->where('name',$permission)->exists(); }
}
