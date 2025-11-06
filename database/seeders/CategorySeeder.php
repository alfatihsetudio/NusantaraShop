<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $cats = ['Elektronik','Pakaian','Rumah Tangga','Kecantikan','Olahraga'];
        foreach($cats as $c) {
            Category::create([
                'name'=>$c,
                'slug'=>\Str::slug($c)
            ]);
        }
    }
}
