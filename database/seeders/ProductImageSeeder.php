<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $basePath = public_path('images/products');
        $productIds = DB::table('products')->pluck('product_id');

        foreach ($productIds as $productId) {
            $productImagePath = $basePath . '/' . $productId;

            if (File::exists($productImagePath)) {
                $images = File::files($productImagePath);

                // Sort images alphabetically to maintain order like 1.jpg, 2.jpg, etc.
                usort($images, function ($a, $b) {
                    return strcmp($a->getFilename(), $b->getFilename());
                });

                foreach ($images as $index => $image) {
                    DB::table('product_images')->insert([
                        'product_id' => $productId,
                        'url' => 'images/products/' . $productId . '/' . $image->getFilename(), // relative public path
                        'is_primary' => $index === 0,
                        'status_del' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
