<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles and Permissions
        $roles = ['admin', 'editor', 'client'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        $adminRole = Role::findByName('admin', 'web');

        $permissions = [
            'projects.manage',
            'services.manage',
            'posts.manage',
            'inquiries.view',
            'settings.manage',
            'media.upload',
            'audit.view'
        ];

        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
            $adminRole->givePermissionTo($permission);
        }

        // 2. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@abaharlou.ir'],
            [
                'name' => 'AmirMohammad Baharlou',
                'password' => Hash::make('Password123!'),
                'phone' => '09120000000',
                'locale' => 'fa',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // 3. System Settings
        $settingsData = [
            [
                'key' => 'site_title',
                'group' => 'general',
                'is_public' => true,
                'translations' => [
                    'fa' => 'امیرمحمد بهارلو — پلتفرم شخصی و پورتفولیو',
                    'en' => 'AMB — Personal Platform & Portfolio'
                ]
            ],
            [
                'key' => 'site_tagline',
                'group' => 'general',
                'is_public' => true,
                'translations' => [
                    'fa' => 'توسعه‌دهنده وب و معمار سیستم‌های مقیاس‌پذیر',
                    'en' => 'Full-Stack Developer & Scalable Systems Architect'
                ]
            ],
            [
                'key' => 'currency',
                'group' => 'estimator',
                'is_public' => true,
                'translations' => [
                    'fa' => 'تومان',
                    'en' => 'Toman'
                ]
            ],
        ];

        foreach ($settingsData as $s) {
            $settingId = DB::table('settings')->insertGetId([
                'key' => $s['key'],
                'group' => $s['group'],
                'type' => 'text',
                'is_public' => $s['is_public'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($s['translations'] as $loc => $val) {
                DB::table('setting_translations')->insert([
                    'setting_id' => $settingId,
                    'locale' => $loc,
                    'value' => $val,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 4. Sample Technologies
        $techLaravel = DB::table('technologies')->insertGetId([
            'name' => 'Laravel',
            'slug' => 'laravel',
            'icon' => 'code',
            'category' => 'backend',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $techThree = DB::table('technologies')->insertGetId([
            'name' => 'Three.js',
            'slug' => 'threejs',
            'icon' => 'box',
            'category' => 'frontend',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Sample Demo Project
        $projectId = DB::table('projects')->insertGetId([
            'public_id' => '01JAMPB1234567890ABCDEFGH0',
            'featured' => true,
            'status' => 'published',
            'order' => 1,
            'is_demo' => true,
            'github_url' => 'https://github.com/abaharloo4/amb',
            'published_at' => now(),
            'created_by' => $admin->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('project_translations')->insert([
            [
                'project_id' => $projectId,
                'locale' => 'fa',
                'slug' => 'amb-platform',
                'title' => 'پلتفرم برند شخصی AMB',
                'summary' => 'معماری Modular Monolith با لاراول و رابط کاربری Three.js',
                'challenge' => 'ایجاد پرفورمنس ۶۰fps همزمان با سئو عالی رندر سمت سرور',
                'solution' => 'تفکیک ماژول‌ها و بارگذاری تنبل چانک‌های سه‌بعدی',
                'result' => 'لود سریع زیر ۱ ثانیه با فریم‌ریت پایدار',
                'client_name' => 'AMB Brand',
                'search_text' => 'پلتفرم برند شخصی لاراول سه بعدی',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $projectId,
                'locale' => 'en',
                'slug' => 'amb-platform-en',
                'title' => 'AMB Personal Platform',
                'summary' => 'Modular Monolith architecture with Laravel & Three.js creative UI',
                'challenge' => 'Achieving 60fps performance alongside SSR SEO compliance',
                'solution' => 'Code-split lazy chunks and decoupled reactive ticker loop',
                'result' => 'Sub-second page loads and sustained 60fps frame rate',
                'client_name' => 'AMB Brand',
                'search_text' => 'amb personal platform laravel threejs',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('project_technology')->insert([
            ['project_id' => $projectId, 'technology_id' => $techLaravel],
            ['project_id' => $projectId, 'technology_id' => $techThree],
        ]);

        // 6. Sample Demo Service
        $serviceId = DB::table('services')->insertGetId([
            'icon' => 'layers',
            'featured' => true,
            'status' => 'published',
            'order' => 1,
            'is_demo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('service_translations')->insert([
            [
                'service_id' => $serviceId,
                'locale' => 'fa',
                'slug' => 'custom-web-development',
                'title' => 'توسعه وب اختصاصی و مقیاس‌پذیر',
                'summary' => 'طراحی و پیاده‌سازی سیستم‌های مدرن با لاراول و رابط‌های کاربری تعاملی',
                'description' => 'پیاده‌سازی ماژولار با در نظر گرفتن استانداردهای امنیتی، سرعت و مقیاس‌پذیری بالا.',
                'deliverables' => json_encode(['معماری داده', 'داشبورد اختصاصی', 'API و وب‌سرویس']),
                'faq' => json_encode([['q' => 'آیا پروژه با گیت تحویل می‌شود؟', 'a' => 'بله با مخزن کامل و مستندات.']]),
                'search_text' => 'توسعه وب اختصاصی لاراول مقیاس پذیر',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_id' => $serviceId,
                'locale' => 'en',
                'slug' => 'custom-web-development-en',
                'title' => 'Custom Scalable Web Development',
                'summary' => 'Engineering high-performance web systems with Laravel and creative UIs',
                'description' => 'Modular software engineering designed for performance and security.',
                'deliverables' => json_encode(['Data Architecture', 'Custom Admin Panel', 'REST APIs']),
                'faq' => json_encode([['q' => 'Is Git repository included?', 'a' => 'Yes, with complete docs.']]),
                'search_text' => 'custom web development scalable laravel',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
