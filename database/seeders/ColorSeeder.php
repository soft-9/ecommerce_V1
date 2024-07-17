<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = ['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White'];
        
        foreach ($colors as $color) {
            Color::create(['name' => $color]);
        }
    }
}