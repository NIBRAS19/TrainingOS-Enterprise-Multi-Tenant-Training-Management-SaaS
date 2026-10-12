<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class Document extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','owner_type','owner_id','category','title','current_version_id','visibility','status'];
    public function versions(){return $this->hasMany(DocumentVersion::class);}
}
