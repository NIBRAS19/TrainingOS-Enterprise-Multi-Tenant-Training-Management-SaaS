<?php
namespace App\Http\Controllers\Api;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
class CalendarController extends BaseTenantController
{
 public function __invoke(Request $request){
  $from=$request->date('from')??now()->startOfMonth();
  $to=$request->date('to')??now()->endOfMonth();
  abort_if($to->lt($from),422,'The end date must be on or after the start date.');
  $sessions=TrainingSession::query()->with(['batch.course','batch.trainer.user'])->whereBetween('starts_at',[$from->copy()->startOfDay(),$to->copy()->endOfDay()])->orderBy('starts_at')->get();
  return $this->ok($sessions);
 }
}
