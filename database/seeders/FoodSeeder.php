<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;
use Illuminate\Support\Facades\File;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('data/FoodData_Central_foundation_food_json.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("El archivo no existe en: {$jsonPath}");
            return;
        }

        $json = File::get($jsonPath);
        $data = json_decode($json, true);

        if (!isset($data['FoundationFoods']) || !is_array($data['FoundationFoods'])) {
            $this->command->error("Estructura de JSON no válida o dañada.");
            return;
        }

        $records = [];
        $now = now();

        foreach ($data['FoundationFoods'] as $item) {
            // Salta los elementos 'null' o corruptos que están en el JSON
            if (is_null($item) || !is_array($item)) {
                continue;
            }

            $nutrients = collect($item['foodNutrients'] ?? []);

            // Uso de data_get() para evitar errores si el nutriente es null
            $calories = data_get($nutrients->firstWhere('nutrient.id', 1008), 'amount', 0);
            $protein  = data_get($nutrients->firstWhere('nutrient.id', 1003), 'amount', 0);
            $fat      = data_get($nutrients->firstWhere('nutrient.id', 1004), 'amount', 0);
            $carbs    = data_get($nutrients->firstWhere('nutrient.id', 1005), 'amount', 0);

            $records[] = [
                'name'       => data_get($item, 'description', 'Sin descripción'),
                'category'   => data_get($item, 'foodCategory.description', 'General'),
                'portion'    => 100.00,
                'unit'       => 'g',
                'calories'   => round((float) $calories, 2),
                'protein'    => round((float) $protein, 2),
                'carbs'      => round((float) $carbs, 2),
                'fat'        => round((float) $fat, 2),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (empty($records)) {
            $this->command->warn("No se encontraron registros válidos para importar.");
            return;
        }

        // Insertar en bloques de 100 registros
        foreach (array_chunk($records, 100) as $chunk) {
            Food::insert($chunk);
        }

        $this->command->info("¡Se importaron " . count($records) . " alimentos correctamente!");
    }
}
