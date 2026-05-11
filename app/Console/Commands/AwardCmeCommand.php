<?php

namespace App\Console\Commands;

use App\Services\Cme\CmeService;
use Illuminate\Console\Command;

class AwardCmeCommand extends Command
{
    protected $signature = 'congresia:award-cme';

    protected $description = "Calcule et attribue les crédits CME selon les présences scannées.";

    public function handle(CmeService $cme): int
    {
        $this->info('Calcul des crédits CME en cours…');
        $count = $cme->recomputeAll();
        $this->info("✓ {$count} crédits attribués/synchronisés.");

        return self::SUCCESS;
    }
}
