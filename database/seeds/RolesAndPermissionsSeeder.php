<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'dashboard.index',

            'roles.index',
            'roles.store',
            'roles.update',
            'roles.destroy',

            'users.index',
            'users.store',
            'users.update',
            'users.destroy',
            'users.assignRoles',
            'users.assignPermissions',

            'product_categories.index',
            'product_categories.store',
            'product_categories.update',
            'product_categories.destroy',

            'settings.index',
            'settings.log',
            'settings.destroy',
            'settings.update',

            'categories.index',
            'categories.store',
            'categories.update',
            'categories.destroy',

            'posts.index',
            'posts.store',
            'posts.update',
            'posts.destroy',

            'reviews.index',
            'reviews.destroy',
            'reviews.update',

            'orders.index',
            'orders.destroy',
            'orders.store',
            'orders.update',
            'orders.show',

            'sliders.index',
            'sliders.destroy',
            'sliders.store',
            'sliders.update',

            'banners.index',
            'banners.destroy',
            'banners.store',
            'banners.update',

            'redirections.index',
            'redirections.destroy',
            'redirections.store',
            'redirections.update',

            'Branches.index',
            'Branches.destroy',
            'Branches.store',
            'Branches.update',

            'brands.index',
            'brands.destroy',
            'brands.store',
            'brands.update',

            'products.index',
            'products.store',
            'products.update',
            'products.destroy',

            'pages.index',
            'pages.store',
            'pages.update',
            'pages.destroy',

            'text_links.index',
            'text_links.store',
            'text_links.update',
            'text_links.destroy',

            'contacts.index',
            'contacts.store',
            'contacts.update',
            'contacts.destroy',

            'contacts_receiver.index',
            'contacts_receiver.store',
            'contacts_receiver.update',
            'contacts_receiver.destroy',

            'attribute.index',
            'attribute.store',
            'attribute.update',
            'attribute.destroy',

            'crawl_report.index',
            'crawl_report.store',
            'crawl_report.update',
            'crawl_report.destroy',
        ];

        foreach ($permissions as $permission) {
            if (!Permission::whereName($permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // create roles and assign created permissions
        if (!Role::whereName('Super Admin')->exists()) {
            Role::create(['name' => 'Super Admin'])->givePermissionTo(Permission::all());

            // create default admin
            $user = User::create([
                'name'     => 'Nguyễn Văn Vương',
                'email'    => 'maytinhvietanh2011@gmail.com',
                'password' => bcrypt('Mtva2011#'),
            ]);

            $user->assignRole('Super Admin');
        }

        if (!Role::whereName('Customer')->exists()) {
            Role::create(['name' => 'Customer']);
        }
    }
}
