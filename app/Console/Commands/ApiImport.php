<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Console\Command;

class ApiImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:api {url?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from an API URL';

    /**
     * The default URL we will pull the API import from
     * This hardcoded but overridable value allows for easier API swapout without codebase updates
     * 
     * @var string
     */
    protected $url = 'https://nt5gkznl19.execute-api.eu-west-1.amazonaws.com/prod/products';

    protected $categoryRepository;
    protected $productRepository;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->categoryRepository = new CategoryRepository();
        $this->productRepository = new ProductRepository();

        if ($this->argument('url')) {
            $this->url = $this->argument('url');
        }

        $this->line("Pulling API data from: ".$this->url);

        /**
         * Could refactor this into queued events
         */
        while (!is_null($this->url)) {
            $data = json_decode(file_get_contents($this->url), true);
            $this->line('A page of data has been obtained. Products found.');

            foreach($data["value"] as $product) {
                $category = $this->categoryRepository->findOrCreate($product["category"]);
                $this->line('Found or Created Category: '.$category->name);

                $saved = $this->productRepository->findOrCreate(
                    $this->formatProduct($product, $category)
                );
                $this->line('Found or Created Product: '.$saved->sku);
            }

            $this->url = $data["@odata.nextLink"];
        }

        $this->info('Completed');
        return 0; // Zero errors
    }

    private function formatProduct(array $product, Category $category)
    {
        // Attach Category ID
        $product["category_id"] = $category->id;
        unset($product["category"]);

        return $product;
    }
}
