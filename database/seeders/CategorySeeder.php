<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use TruncateTable,DisableForeignKeys;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate('categories');
        Category::factory(10)->create();
        $this->enableForeignKeys();
    }
}
