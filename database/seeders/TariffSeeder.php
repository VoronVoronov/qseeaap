<?php

namespace Database\Seeders;

use App\Models\Tariff;
use App\Models\TariffAccess;
use App\Models\TariffModule;
use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedTariffModules();
        $this->seedTariffs();
        $this->seedTariffAccesses();
    }

    private function seedTariffModules(): void
    {
        $tariffModules = [
            ['name' => 'Внешний вид', 'code' => 'appearance'],
            ['name' => 'Категории', 'code' => 'category'],
            ['name' => 'Товары', 'code' => 'product'],
            ['name' => 'Заказы', 'code' => 'order'],
            ['name' => 'Скидки', 'code' => 'discount'],
            ['name' => 'Вызов официанта', 'code' => 'waiter'],
            ['name' => 'Столы', 'code' => 'table'],
            ['name' => 'Аналитика', 'code' => 'analytics'],
            ['name' => 'Юнит экономика', 'code' => 'unit_economy'],
            ['name' => 'Онлайн оплата', 'code' => 'online_payment'],
        ];

        foreach ($tariffModules as $tariffModule) {
            TariffModule::updateOrCreate(['code' => $tariffModule['code']], $tariffModule);
        }
    }

    private function seedTariffs(): void
    {
        $discounts = [
            'three_month' => 0.05,
            'six_month' => 0.1,
            'one_year' => 0.15,
        ];

        $prices = [
            'standard' => 1000,
            'premium' => 10000,
        ];

        $tariffs = [
            [
                'name' => 'Бесплатный',
                'price_one_month' => 0,
                'price_three_month' => 0,
                'price_six_month' => 0,
                'price_one_year' => 0,
            ],
            [
                'name' => 'Стандарт',
                'price_one_month' => $prices['standard'],
                'price_three_month' => $this->calculateDiscountedPrice($prices['standard'], $discounts['three_month'], 3),
                'price_six_month' => $this->calculateDiscountedPrice($prices['standard'], $discounts['six_month'], 6),
                'price_one_year' => $this->calculateDiscountedPrice($prices['standard'], $discounts['one_year'], 12),
            ],
            [
                'name' => 'Премиум',
                'price_one_month' => $prices['premium'],
                'price_three_month' => $this->calculateDiscountedPrice($prices['premium'], $discounts['three_month'], 3),
                'price_six_month' => $this->calculateDiscountedPrice($prices['premium'], $discounts['six_month'], 6),
                'price_one_year' => $this->calculateDiscountedPrice($prices['premium'], $discounts['one_year'], 12),
            ],
        ];

        foreach ($tariffs as $tariff) {
            Tariff::updateOrCreate(['name' => $tariff['name']], $tariff);
        }
    }

    private function seedTariffAccesses(): void
    {
        $tariffAccesses = [
            1 => [1, 2, 3, 4, 5],
            2 => [1, 2, 3, 4, 5, 6, 7, 8],
            3 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        ];

        foreach ($tariffAccesses as $tariffId => $moduleIds) {
            foreach ($moduleIds as $moduleId) {
                TariffAccess::updateOrCreate([
                    'tariff_id' => $tariffId,
                    'tariff_module_id' => $moduleId,
                ]);
            }
        }
    }

    private function calculateDiscountedPrice(float $basePrice, float $discount, int $months): float
    {
        return round(($basePrice * (1 - $discount)) * $months, 2);
    }
}
