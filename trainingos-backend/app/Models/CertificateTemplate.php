<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class CertificateTemplate extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','name','html','paper_size','orientation','status','is_default'];
    protected function casts(): array { return ['is_default'=>'boolean']; }
}
