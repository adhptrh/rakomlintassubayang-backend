<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat = new Category;
        $cat->name = "Khabar Desa";
        $cat->save();
        $cat = new Category;
        $cat->name = "Event";
        $cat->save();
        $cat = new Category;
        $cat->name = "Program";
        $cat->save();
        $cat = new Category;
        $cat->name = "Berita";
        $cat->save();
    }
}
