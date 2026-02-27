<?php
 
namespace Database\Seeders;
 
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
 
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
 
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
 
        $this->call([
            PermissionsSeeder::class,
            RolesSeeder::class,
            AdminsSeeder::class,
            PermissionRoleTableSeeder::class,
            BannerSettingSeeder::class,
            WebsiteSettingSeeder::class,
            PageSeeder::class,
            VisibilitySettingSeeder::class,
            EmailTemplateSeeder::class
        ]);
    }
}
