<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gig>
 */
class GigFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = array(
            "كتابة مقالات احترافية",
            "ترجمة المقالات والنصوص",
            "تصميم شعارات وهويات بصرية",
            "إعداد تقارير وأبحاث",
            "تحرير وإعادة صياغة المحتوى",
            "تصميم وتطوير المواقع الإلكترونية",
            "تحرير الصور والتصميم الجرافيكي",
            "الكتابة الإبداعية والشعر",
            "التسويق الإلكتروني والإعلان",
            "تحويل الملفات من PDF إلى Word",
            "التعليق الصوتي والإعلان الإذاعي",
            "تدقيق اللغوي والتدقيق الإملائي",
            "تصميم العروض التقديمية",
            "تصميم الكتب الإلكترونية والمطبوعات",
            "إدارة الحسابات على وسائل التواصل الاجتماعي",
            "تصميم وإدارة حملات الإعلان على وسائل التواصل الاجتماعي",
            "إدارة المشاريع وتنسيقها",
            "تصميم الرسومات الهندسية والتصاميم الصناعية",
            "تحرير وإنتاج الفيديو",
            "الكتابة على المدونات والمواقع",
            "تصميم وإعداد البطاقات الشخصية والدعوات",
            "تحرير الصوت وتحرير الأفلام",
            "تصميم الرسوم التوضيحية والمخططات البيانية",
            "إدخال البيانات والتحقق منها",
            "تصميم الأزياء والملابس",
            "تصميم وتطوير الألعاب الإلكترونية",
            "تصميم العلامات التجارية والشعارات",
            "تصميم الإعلانات المطبوعة والتلفزيونية",
            "تصميم وإعداد البريد الإلكتروني والنشرات الإخبارية",
            "ترتيب وتنظيم الملفات والوثائق",
            "تحرير وتصمي"
        );
        $directory = storage_path('app/public/images/gigs/');
        $thumbnails = array_diff(scandir($directory), array('..', '.'));
        return [
            'status' => fake()->randomElement(['pending', 'active', 'inactive']),
            'title' => fake()->randomElement($services),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->realText(1000),
            'thumbnails' => fake()->randomElements($thumbnails, 3),
            'delivery_time' => rand(1, 30),
            'instructions' => fake()->realText(100),
            'price' => fake()->randomFloat(2, 5, 300),
            'user_changes' => null,
            'language' => 'ar',
            'user_id' => (User::inRandomOrder()->first())->id,
            'category_id' => (Category::inRandomOrder()->first())->id,
        ];
    }
}
