<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'role-list', 'role-create', 'role-edit', 'role-delete',
            'product-list', 'product-create', 'product-edit', 'product-delete',
            'permission-list', 'permission-create', 'permission-edit', 'permission-delete',
            'role-assign', 'theme-color',
            'rule-list', 'rule.edit',
            'activity-list', 'activity-delete',
            'setting-shop_info',
            'config-list', 'config-edit',
            'theme-save', 'shop-info-save',
           
        ];

        foreach ($permissions as $permission) {
            // បង្កើត Permission ថ្មី បើវាមិនទាន់មានក្នុង Database 
            // (ប្រើ firstOrCreate ដើម្បីការពារកុំឱ្យ Error ពេល Run កូដនេះពីរដង)
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}