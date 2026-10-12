<?php
namespace App\Models;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
class DocumentVersion extends Model
{
    use BelongsToTenant;
    protected $fillable=['organization_id','document_id','version','path','mime_type','size','uploaded_by','checksum'];
    protected function casts(): array { return ['version'=>'integer','size'=>'integer']; }
}
