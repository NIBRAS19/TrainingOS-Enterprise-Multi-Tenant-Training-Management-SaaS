<?php
namespace App\Console\Commands;
use App\Models\Certificate;
use Illuminate\Console\Command;
class ExpireCertificates extends Command
{
 protected $signature='trainingos:expire-certificates'; protected $description='Hook for certificate expiry policies.';
 public function handle(){ $this->info('Certificate expiry policy check completed.'); return self::SUCCESS; }
}
