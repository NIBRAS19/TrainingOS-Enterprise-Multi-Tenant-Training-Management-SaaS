<?php
namespace App\Http\Controllers\Api;
use App\Models\NotificationItem;
use Illuminate\Http\Request;
class NotificationController extends BaseTenantController
{
 public function index(Request $r){$q=NotificationItem::where('user_id',$r->user()->id)->latest();return $this->paginated($q->paginate(min((int)$r->input('per_page',20),100)));}
 public function read(Request $r,NotificationItem $notification){abort_unless($notification->user_id===$r->user()->id,403);$notification->update(['read_at'=>now()]);return $this->ok($notification,'Notification marked as read');}
 public function readAll(Request $r){NotificationItem::where('user_id',$r->user()->id)->whereNull('read_at')->update(['read_at'=>now()]);return $this->ok(null,'Notifications marked as read');}
}
