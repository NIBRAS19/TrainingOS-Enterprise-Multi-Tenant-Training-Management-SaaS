<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class CourseMaterial extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','course_id','title','type','path','mime_type','size','url','is_public'];
    protected function casts(): array { return ['size'=>'integer','is_public'=>'boolean']; }
}
