<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Console\Command;

class CsvImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv {file?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from a CSV file (default: orders.csv)';

    protected $file = 'orders.csv';

    protected $customerRepository;
    protected $orderRepository;
    protected $productRepository;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->customerRepository = new CustomerRepository();
        $this->orderRepository = new OrderRepository();
        $this->productRepository = new ProductRepository();

        // Use file argument if we have one otherwise use default filename
        $this->file = "./storage/".($this->argument('file') ?: $this->file);
        $this->line("Pulling order data from: ".$this->file);

        /**
         * Could refactor this into queued events
         */
        $row = 0; // Header, 1 and above is for data
        if (($handle = fopen($this->file, "r")) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                if ($row > 0) { // If this is not the header row
                    $saved = $this->orderRepository->addOrderItem(
                        $this->mapData($data)
                    );

                    $this->line("Added Order Item: ".$data[0]."-".$data[2]);
                }

                $row++;
            }

            fclose($handle);
        }

        $this->info('Complete');
        return 0;
    }

    /**
     * Add / find the customer and
     * Map the data array to store the order record
     */
    private function mapData($data)
    {
        $customer = $this->customerRepository->findOrCreate($data[1]);
        $this->line("Customer: ".$customer->id." - ".$customer->name);

        $order = $this->orderRepository->findOrCreate($data[0], $customer->id);
        $this->line("Order: ".$order->id);

        $product = $this->productRepository->findBy('sku', $data[2]);

        return [
            "order_id" => $order->id,
            // "product_id" => $product->id,
            "sku" => $data[2],
            "quantity" => $data[3],
        ];
    }
}
