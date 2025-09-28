<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Ноутбук HP Pavilion',
                'description' => 'Мощный ноутбук для работы и игр',
                'price' => 45000,
                'stock_quantity' => 15,
            ],
            [
                'name' => 'Мышь Logitech MX',
                'description' => 'Беспроводная компьютерная мышь',
                'price' => 3500,
                'stock_quantity' => 50,
            ],
            [
                'name' => 'Клавиатура Mechanical',
                'description' => 'Механическая клавиатура с подсветкой',
                'price' => 6000,
                'stock_quantity' => 25,
            ],
            [
                'name' => 'Монитор 24" Samsung',
                'description' => 'Монитор Full HD для офиса',
                'price' => 15000,
                'stock_quantity' => 10,
            ],
            [
                'name' => 'Наушники Sony WH',
                'description' => 'Беспроводные наушники с шумоподавлением',
                'price' => 12000,
                'stock_quantity' => 30,
            ],
            [
                'name' => 'Смартфон Xiaomi',
                'description' => 'Смартфон с хорошей камерой',
                'price' => 20000,
                'stock_quantity' => 20,
            ],
            [
                'name' => 'Планшет iPad Air',
                'description' => 'Планшет для работы и творчества',
                'price' => 35000,
                'stock_quantity' => 8,
            ],
            [
                'name' => 'Флешка 64GB',
                'description' => 'USB флеш-накопитель',
                'price' => 800,
                'stock_quantity' => 100,
            ],
            [
                'name' => 'Внешний диск 1TB',
                'description' => 'Внешний жесткий диск',
                'price' => 4000,
                'stock_quantity' => 12,
            ],
            [
                'name' => 'Роутер TP-Link',
                'description' => 'Wi-Fi роутер для дома',
                'price' => 2500,
                'stock_quantity' => 18,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('10 тестовых товаров создано!');
    }
}
