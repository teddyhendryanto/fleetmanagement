<?php

use Illuminate\Database\Seeder;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('sites')->insert([
          'short_name' => 'KIM',
          'full_name' => 'KARYA INDAH MULTIGUNA',
          'created_at' => date('Y-m-d H:i:s')
      ]);

      DB::table('sites')->insert([
          'short_name' => 'MBI',
          'full_name' => 'MULTIBOX INDAH',
          'created_at' => date('Y-m-d H:i:s')
      ]);
    }
}
