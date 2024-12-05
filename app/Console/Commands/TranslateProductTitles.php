<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class TranslateProductTitles extends Command
{
    protected $signature = 'products:translate-titles';
    protected $description = 'Translate product titles from English to Arabic';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Retrieve all products
        $products = Product::all();

        foreach ($products as $product) {
            // Check if the product title in English exists and the Arabic title is missing
            if (isset($product->title['en']) && empty($product->title['ar'])) {
                $titleEn = $product->title['en'];

                // Prepare API URL
                $apiUrl = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=ar&dt=t&q=" . urlencode($titleEn);

                // Make the HTTP request to the translation API
                $response = Http::get($apiUrl);

                // Check if the request was successful
                if ($response->successful()) {
                    // Decode the response
                    $result = $response->json();

                    // Check if the response contains translations
                    if (isset($result[0][0][0])) {
                        $translatedText = $result[0][0][0];
                        // Update the title attribute
                        $title = $product->title;
                        $title['ar'] = $translatedText;
                        $product->title = $title; // Use the entire title array
                        $product->save();

                        // Output the result to console
                        $this->info("Translated product ID {$product->id}");
                    } else {
                        $this->error("Translation not found for product ID {$product->id}");
                    }
                } else {
                    $this->error("Error translating product ID {$product->id}: " . $response->status());
                }
            }
        }

        $this->info('Translation complete!');
    }
}
