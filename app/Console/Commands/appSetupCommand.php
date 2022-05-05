<?php

namespace App\Console\Commands;

use App\Models\AppSetting;
use App\Models\Category;
use App\Models\Identity;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class appSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::whereEmail('david@vaneffen.be')->first();

        $tenant = new Tenant();
        $tenant->name = 'MSE BE';
        $tenant->shortname = 'BE';
        $tenant->save();

        if (is_null($user)) {
            $this->info('creating admin...');
            $user = new User();
            $user->firstname = 'David';
            $user->name = 'Van Effen';
            $user->email = 'david@vaneffen.be';
            $user->tenant_id = $tenant->id;
            $user->is_superadmin = true;
            $user->password = Hash::make('booger');
            $user->save();

        }

        $permission = Permission::firstOrCreate(['name' => 'module.users']);
        if (!is_null($user) && !$user->hasPermissionTo($permission->id)) {
            $user->givePermissionTo($permission);
        }
        $permission = Permission::firstOrCreate(['name' => 'module.settings']);
        if (!is_null($user) && !$user->hasPermissionTo($permission->id)) {
            $user->givePermissionTo($permission);
        }
        $permission = Permission::firstOrCreate(['name' => 'module.logs']);
        if (!is_null($user) && !$user->hasPermissionTo($permission->id)) {
            $user->givePermissionTo($permission);
        }
        $permission = Permission::firstOrCreate(['name' => 'module.rfa']);
        if (!is_null($user) && !$user->hasPermissionTo($permission->id)) {
            $user->givePermissionTo($permission);
        }

        $this->info('making settings...');
        $app_settings = array(
            array(
                "setting_key" => "login_bg",
                "setting_value" => "/",
                "setting_type" => "image",
            ),
            array(
                "setting_key" => "app_name",
                "setting_value" => "MSE App",
                "setting_type" => null,
            ),

        );
        foreach ($app_settings as $key => $setting) {
            AppSetting::firstOrCreate(['setting_key' => $setting['setting_key'], 'setting_value' => $setting['setting_value'], 'setting_type' => isset($setting['setting_type']) ? $setting['setting_type'] : null]);
        }


        $tenant = new Tenant();
        $tenant->name = 'MSE UK';
        $tenant->shortname = 'UK';
        $tenant->save();

        $tenant = new Tenant();
        $tenant->name = 'MSE CZ';
        $tenant->shortname = 'CZ';
        $tenant->save();

        $tenant = new Tenant();
        $tenant->name = 'MSE TR';
        $tenant->shortname = 'TR';
        $tenant->save();

        $category = new Category();
        $category->tenant_id = 1;
        $category->name = "IT";
        $category->shortname = "IT";
        $category->save();

        $category = new Category();
        $category->tenant_id = 1;
        $category->name = "Travel";
        $category->shortname = "TR";
        $category->save();

        return Command::SUCCESS;
    }
}
