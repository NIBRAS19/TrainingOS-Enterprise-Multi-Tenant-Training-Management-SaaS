<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Role extends Model
{
    protected $fillable=['name','slug','description','system'];
    protected function casts(): array { return ['system'=>'boolean']; }
    public function permissions(): BelongsToMany { return $this->belongsToMany(Permission::class,'role_permissions'); }
}
