<?php

namespace App\Console\Commands;

use App\Models\TariffMenu;
use Carbon\Carbon;
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
    protected $description = 'Check expired tariff and change to default tariff';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tariffs = TariffMenu::where('no_deadline', 0)->get();
        foreach ($tariffs as $tariff) {
            if ($tariff->expired_at <= Carbon::now()) {
                TariffMenu::create([
                    'menu_id' => $tariff->menu_id,
                    'tariff_id' => 1,
                    'no_deadline' => 1,
                ]);
                $tariff->delete();
            }
        }
    }
}
