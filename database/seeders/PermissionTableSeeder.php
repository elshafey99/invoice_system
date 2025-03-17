<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [

            'Invoices',
            'Invoice List',
            'Paid Invoices',
            'Partially Paid Invoices',
            'Unpaid Invoices',
            'Invoice Archive',
            'Reports',
            'Invoice Report',
            'Customer Report',
            'Users',
            'User List',
            'User Permissions',
            'Settings',
            'Products',
            'Sections',

            'Add Invoice',
            'Delete Invoice',
            'Export to Excel',
            'Change Payment Status',
            'Edit Invoice',
            'Archive Invoice',
            'Print Invoice',
            'Add Attachment',
            'Delete Attachment',

            'Add User',
            'Edit User',
            'Delete User',

            'View Validity',
            'Add Validity',
            'Edit Validity',
            'Delete Validity',

            'Add Product',
            'Edit Product',
            'Delete Product',

            'Add Section',
            'Edit Section',
            'Delete Section',
            'Notifications',

            // 'الفواتير',
            // 'قائمة الفواتير',
            // 'الفواتير المدفوعة',
            // 'الفواتير المدفوعة جزئيا',
            // 'الفواتير الغير مدفوعة',
            // 'ارشيف الفواتير',
            // 'التقارير',
            // 'تقرير الفواتير',
            // 'تقرير العملاء',
            // 'المستخدمين',
            // 'قائمة المستخدمين',
            // 'صلاحيات المستخدمين',
            // 'الاعدادات',
            // 'المنتجات',
            // 'الاقسام',


            // 'اضافة فاتورة',
            // 'حذف الفاتورة',
            // 'تصدير EXCEL',
            // 'تغير حالة الدفع',
            // 'تعديل الفاتورة',
            // 'ارشفة الفاتورة',
            // 'طباعةالفاتورة',
            // 'اضافة مرفق',
            // 'حذف المرفق',

            // 'اضافة مستخدم',
            // 'تعديل مستخدم',
            // 'حذف مستخدم',

            // 'عرض صلاحية',
            // 'اضافة صلاحية',
            // 'تعديل صلاحية',
            // 'حذف صلاحية',

            // 'اضافة منتج',
            // 'تعديل منتج',
            // 'حذف منتج',

            // 'اضافة قسم',
            // 'تعديل قسم',
            // 'حذف قسم',
            // 'الاشعارات',

        ];



        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }
    }
}
