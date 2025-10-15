<?php

namespace Modules\UserRoles\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\UserRoles\Models\Permission;
use Spatie\Permission\Models\Role;
use Modules\Users\Models\User;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionGroups = [
            'Access Role' => [
                'user.index',
                'user.create',
                'user.edit',
                'user.delete',
                'user.show',
                'role.index',
                'role.create',
                'role.edit',
                'role.delete',
                'role.show',
                'permission.index',
                'permission.create',
                'permission.edit',
                'permission.delete',
                'permission.show',
            ],
            'Blog' => [
                'post.index',
                'post.create',
                'post.edit',
                'post.delete',
                'post.show',
                'category.index',
                'category.create',
                'category.edit',
                'category.delete',
                'category.show',
                'tag.index',
                'tag.create',
                'tag.edit',
                'tag.delete',
                'tag.show',
            ],
            'Donation' => [
                'campaign.index',
                'campaign.create',
                'campaign.edit',
                'campaign.delete',
                'campaign.show',
                'campaign-category.index',
                'campaign-category.create',
                'campaign-category.edit',
                'campaign-category.delete',
                'campaign-category.show',
            ],
            'Page Bulder' => [
                'pages.index',
                'pages.create',
                'pages.edit',
                'pages.delete',
                'pages.show',
                'components.index',
                'components.create',
                'components.edit',
                'components.delete',
                'components.show',
            ],
            'Contact/Join Us' => [
                'contact.index',
                'contact.create',
                'contact.edit',
                'contact.delete',
                'contact.show',
                'team.applications.index',
                'team.applications.create',
                'team.applications.edit',
                'team.applications.delete',
                'team.applications.show',
                'volunteer.applications.index',
                'volunteer.applications.create',
                'volunteer.applications.edit',
                'volunteer.applications.delete',
                'volunteer.applications.show',
                'membership.applications.index',
                'membership.applications.create',
                'membership.applications.edit',
                'membership.applications.delete',
                'membership.applications.show',
                'myspace.applications.index',
                'myspace.applications.create',
                'myspace.applications.edit',
                'myspace.applications.delete',
                'myspace.applications.show',
            ],
            'Testimonials' => [
                'testimonial.index',
                'testimonial.create',
                'testimonial.edit',
                'testimonial.delete',
                'testimonial.show',
            ],
            'Settings' => [
                'setting.index',
                'setting.smtp',
                'setting.modules.setting',
                'setting.website.tracking',
                'setting.site.appearance',
            ],
            'Recaptcha' => [
                'recaptcha.settings.index',
                'recaptcha.settings.create',
                'recaptcha.settings.store',
                'recaptcha.settings.edit',
                'recaptcha.settings.update',
                'recaptcha.settings.delete',
                'recaptcha.settings.show',
            ],
            'Payment Module' => [
                'payment.gateways.index',
                'payment.gateways.create',
                'payment.gateways.edit',
                'payment.gateways.delete',
                'payment.gateways.show',
                'payment.gateways.update',
                'payment.gateways.store',
            ],
        ];

        $allPermissions = [];

        foreach ($permissionGroups as $category => $permissions) {
            foreach ($permissions as $permission) {
                $perm = Permission::firstOrCreate(
                    ['name' => $permission],
                    ['category' => $category, 'guard_name' => 'web']
                );

                if ($perm->category !== $category) {
                    $perm->update(['category' => $category]);
                }

                $allPermissions[] = $perm->name;
            }
        }

        $this->command->info('✔ Permissions created and grouped.');

        // Create roles
        $superadmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $user = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Assign permissions

        // Superadmin = All
        $superadmin->syncPermissions($allPermissions);

        // Admin = All except roles/permissions & core settings
        $adminPermissions = collect($allPermissions)->reject(function ($permission) {
            return str_contains($permission, 'role.') ||
                str_contains($permission, 'permission.') ||
                str_starts_with($permission, 'setting.') ||
                str_starts_with($permission, 'recaptcha.') ||
                str_starts_with($permission, 'payment.gateways');
        })->values()->all();

        $admin->syncPermissions($adminPermissions);

        // User = Limited read-only permissions
        $user->syncPermissions([
            'user.index',
            'user.show',
            'post.index',
            'post.show',
            'category.index',
            'category.show',
            'tag.index',
            'tag.show',
            'testimonial.index',
            'testimonial.show',
        ]);

        $this->command->info('✔ Roles assigned appropriate permissions.');

        // Create Super Admin user
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
        $superAdminUser->assignRole('superadmin');

        // Create Admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
        $adminUser->assignRole('admin');

        // Create Normal user
        $normalUser = User::firstOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'Normal User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
        $normalUser->assignRole('user');

        $this->command->info('✔ Sample users created: superadmin@example.com, admin@admin.com, user@user.com');
    }
}
