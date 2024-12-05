<?php

namespace App\Console\Commands;

use App\Models\Breand;
use App\Models\ProductCategory;
use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Str;

class GenerateSlugsForProducts extends Command
{
    protected $signature = 'products:generate-slugs';
    protected $description = 'Generate slugs for all products, breands, and categories';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Generate slugs for breands
        $breands = ProductCategory::all();

        foreach ($breands as $breand) {
            if (empty($breand->slug)) {
                // Generate a slug from the breand title (assuming title is a string, not an array)
                $slug = Str::slug($breand->title['en'], '-');
                // Update the breand with the new slug
                $breand->update(['slug' => $slug]);
            }
        }

        $this->info('Slugs generated for all breands.');
    }
}
