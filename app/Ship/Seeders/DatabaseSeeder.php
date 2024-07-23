<?php

namespace App\Ship\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->loadSeedersFromContainers();
    }

    private function loadSeedersFromContainers(): void
    {
        foreach ($this->getSectionPaths() as $sectionPath) {
            $class = 'App\Containers\\' . basename($sectionPath) . '\Data\Seeders\DatabaseSeeder';

            if (class_exists($class)) {
                $this->call($class, false, ['model' => $class]);
            }
        }
    }

    public function getSectionPaths(): array
    {
        return File::directories( app_path('/Containers') );
    }
}
