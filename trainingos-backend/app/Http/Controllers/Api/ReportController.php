<?php
namespace App\Http\Controllers\Api;
use App\Models\AttendanceRecord;
use App\Models\AssessmentAttempt;
use App\Models\Batch;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Learner;
use App\Models\Trainer;
use Illuminate\Http\Request;
class ReportController extends BaseTenantController
{
 public function index(){return $this->ok(['reports'=>[['key'=>'learners','name'=>'Learner Report'],['key'=>'attendance','name'=>'Attendance Report'],['key'=>'course-performance','name'=>'Course Performance'],['key'=>'trainer','name'=>'Trainer Report'],['key'=>'certificates','name'=>'Certificate Report']]]);}
 public function show(Request $r,string $type){$data=match($type){
  'learners'=>Learner::withCount('batches')->get(),
  'attendance'=>['present'=>AttendanceRecord::whereIn('status',['present','late'])->count(),'absent'=>AttendanceRecord::where('status','absent')->count(),'late'=>AttendanceRecord::where('status','late')->count(),'excused'=>AttendanceRecord::where('status','excused')->count()],
  'course-performance'=>AssessmentAttempt::selectRaw('AVG(percentage) average_percentage, COUNT(*) attempts')->first(),
  'trainer'=>Trainer::withCount(['courses','batches'])->get(),
  'certificates'=>Certificate::selectRaw('status, COUNT(*) as total')->groupBy('status')->get(),
  default=>abort(404,'Report not found.'),
 };return $this->ok($data);}
 public function exportCsv(string $type){$rows=$this->show(new Request, $type);return response()->streamDownload(function()use($rows){$data=$rows->getData(true)['data']??[];if(!is_array($data)){$data=[$data];}$first=$data[0]??[];$first=is_object($first)?(array)$first:$first;$cols=array_keys($first);$out=fopen('php://output','w');fputcsv($out,$cols);foreach($data as $row){$row=is_object($row)?(array)$row:$row;fputcsv($out,array_map(fn($k)=>is_scalar($row[$k]??null)?$row[$k]:json_encode($row[$k]),$cols));}fclose($out);},$type.'-report.csv',['Content-Type'=>'text/csv']);}
}
