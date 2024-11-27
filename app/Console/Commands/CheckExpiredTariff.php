<?php

namespace App\Console\Commands;

use App\Models\TariffMenu;
use Illuminate\Console\Command;

class CheckExpiredTariff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expired-tariff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tariffs = TariffMenu::where('no_deadline', 0)->get();
        foreach ($tariffs as $tariff) {
            if ($tariff->expired_at <= date('Y-m-d H:i:s')) {
                $tariff->delete();
                TariffMenu::create([
                    'menu_id' => $tariff->menu_id,
                    'tariff_id' => 1,
                    'no_deadline' => 1,
                ]);
            }
        }
    }
}
