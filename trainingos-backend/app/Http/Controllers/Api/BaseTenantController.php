<?php
namespace App\Http\Controllers\Api;
use App\Support\ApiResponder;
use App\Support\AuditService;
use App\Support\TenantContext;
use Illuminate\Routing\Controller as BaseController;
abstract class BaseTenantController extends BaseController
{
 use ApiResponder;
 public function __construct(protected TenantContext $tenant, protected AuditService $audit) {}
 protected function orgId(): int { return $this->tenant->id(); }
}
