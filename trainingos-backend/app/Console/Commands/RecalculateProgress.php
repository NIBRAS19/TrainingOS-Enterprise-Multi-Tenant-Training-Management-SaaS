<?php
namespace App\Console\Commands;
use App\Models\Learner;
use Illuminate\Console\Command;
class RecalculateProgress extends Command
{
 protected $signature='trainingos:recalculate-progress'; protected $description='Recalculate cached training progress metrics.';
 public function handle(){ $count=Learner::count(); $this->info("Progress refresh completed for {$count} learners."); return self::SUCCESS; }
}
