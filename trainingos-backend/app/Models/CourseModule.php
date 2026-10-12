<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class CourseModule extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','course_id','title','description','sort_order','duration_minutes','status'];
}
