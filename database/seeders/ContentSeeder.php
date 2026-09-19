<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\Download;
use App\Models\AboutStat;
use App\Models\AboutTeam;
use App\Models\AboutValue;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // ── Blog Posts ──────────────────────────────────────────────────────
        $posts = [
            ['title'=>'How to Choose the Right Printer for Your Office','title_ar'=>'كيف تختار الطابعة المناسبة لمكتبك؟','excerpt'=>'A complete guide to picking the perfect printer based on your needs and budget.','excerpt_ar'=>'دليل شامل لاختيار الطابعة المثالية بناءً على احتياجاتك وميزانيتك.','content'=>'Choosing the right printer is an important decision that affects your productivity and operating costs...','content_ar'=>'اختيار الطابعة المناسبة قرار مهم يؤثر على إنتاجيتك وتكاليف تشغيلك...','category'=>'Buying Guides','author'=>'Ahmed Mohamed','author_role'=>'Tech Expert','read_time'=>8,'views'=>2340,'tags'=>['Printers','Buying Guide','Tips'],'published_at'=>'2026-04-20'],
            ['title'=>'Laser vs Inkjet Printers — Which is Better?','title_ar'=>'مقارنة: طابعات الليزر vs طابعات الحبر','excerpt'=>'A detailed comparison between laser and inkjet printers in terms of quality, speed, and cost.','excerpt_ar'=>'مقارنة تفصيلية بين طابعات الليزر وطابعات الحبر من حيث الجودة والسرعة والتكلفة.','content'=>'The most common question when buying a printer: laser or inkjet?...','content_ar'=>'السؤال الأكثر شيوعاً عند شراء طابعة: هل أختار ليزر أم حبر؟...','category'=>'Comparisons','author'=>'Sara Ahmed','author_role'=>'Tech Editor','read_time'=>10,'views'=>3120,'tags'=>['Laser','Inkjet','Comparison'],'published_at'=>'2026-04-15'],
            ['title'=>'5 Ways to Save Printer Ink and Extend Its Life','title_ar'=>'5 طرق لتوفير حبر الطابعة وإطالة عمرها','excerpt'=>'Practical tips to reduce ink consumption and save money while maintaining print quality.','excerpt_ar'=>'نصائح عملية لتقليل استهلاك الحبر وتوفير المال مع الحفاظ على جودة الطباعة.','content'=>'Printer ink is one of the most expensive liquids in the world! But there are smart ways to reduce consumption...','content_ar'=>'حبر الطابعة من أغلى السوائل في العالم! لكن هناك طرق ذكية لتقليل استهلاكه...','category'=>'Tips','author'=>'Mohamed Ali','author_role'=>'Maintenance Engineer','read_time'=>6,'views'=>1890,'tags'=>['Saving','Maintenance','Tips'],'published_at'=>'2026-04-10'],
            ['title'=>'Best Mice of 2026 for Designers and Programmers','title_ar'=>'أفضل ماوسات 2026 للمصممين والمبرمجين','excerpt'=>'A review of the best mice available for professionals — designers and programmers.','excerpt_ar'=>'استعراض لأفضل الماوسات المتاحة في السوق للمحترفين من مصممين ومبرمجين.','content'=>'The right mouse can significantly improve your productivity. We review the best options for 2026...','content_ar'=>'الماوس المناسب يمكن أن يحسن إنتاجيتك بشكل كبير. نستعرض أفضل الخيارات لعام 2026...','category'=>'Reviews','author'=>'Ahmed Mohamed','author_role'=>'Tech Expert','read_time'=>7,'views'=>1560,'tags'=>['Mouse','Review','Professionals'],'published_at'=>'2026-04-05'],
            ['title'=>'How to Maintain Your Printer and Extend Its Life','title_ar'=>'كيف تصون طابعتك وتطيل عمرها الافتراضي؟','excerpt'=>'Simple maintenance steps that keep your printer running longer and save you repair costs.','excerpt_ar'=>'دليل الصيانة الدورية للطابعات: خطوات بسيطة تحافظ على طابعتك وتوفر عليك تكاليف الإصلاح.','content'=>'Regular printer maintenance extends its life and maintains print quality. Here are the essential steps...','content_ar'=>'الصيانة الدورية للطابعة تطيل عمرها وتحافظ على جودة الطباعة. إليك الخطوات الأساسية...','category'=>'Maintenance','author'=>'Mohamed Ali','author_role'=>'Maintenance Engineer','read_time'=>9,'views'=>2780,'tags'=>['Maintenance','Printers','Tips'],'published_at'=>'2026-03-30'],
            ['title'=>'Sony WH-1000XM5 Review — Is It Worth the Price?','title_ar'=>'مراجعة: سماعة Sony WH-1000XM5 - هل تستحق السعر؟','excerpt'=>'A full review of the Sony WH-1000XM5 covering sound quality, comfort, and noise cancellation.','excerpt_ar'=>'مراجعة شاملة لسماعة Sony WH-1000XM5 من حيث الصوت والراحة وخاصية إلغاء الضوضاء.','content'=>'Sony WH-1000XM5 is considered one of the best noise-cancelling headphones on the market. But is it worth the price?...','content_ar'=>'Sony WH-1000XM5 تُعتبر من أفضل سماعات إلغاء الضوضاء في السوق. لكن هل تستحق سعرها المرتفع؟...','category'=>'Reviews','author'=>'Sara Ahmed','author_role'=>'Tech Editor','read_time'=>8,'views'=>4230,'tags'=>['Headphones','Sony','Review'],'published_at'=>'2026-03-25'],
        ];

        foreach ($posts as $p) {
            BlogPost::updateOrCreate(
                ['title' => $p['title']],
                $p
            );
        }

        // ── Downloads ───────────────────────────────────────────────────────
        $downloads = [
            ['title'=>'HP Printer Drivers - Complete Package','description'=>'Complete driver package for all HP LaserJet and OfficeJet printers. Compatible with Windows 10/11.','category'=>'Drivers','brand'=>'HP','version'=>'2.5.1','size'=>'145 MB','os'=>'Windows 10/11','icon'=>'fa-print','downloads'=>12450],
            ['title'=>'Canon PIXMA Printer Drivers','description'=>'Official drivers for Canon PIXMA G-Series printers. Includes print and scan software.','category'=>'Drivers','brand'=>'Canon','version'=>'3.2.0','size'=>'98 MB','os'=>'Windows 10/11','icon'=>'fa-print','downloads'=>8920],
            ['title'=>'Epson EcoTank Printer Drivers','description'=>'Drivers and utilities for Epson EcoTank printers. Supports wireless and mobile printing.','category'=>'Drivers','brand'=>'Epson','version'=>'4.1.2','size'=>'112 MB','os'=>'Windows 10/11','icon'=>'fa-print','downloads'=>7650],
            ['title'=>'Brother Printer Drivers','description'=>'Complete driver package for Brother HL, DCP, and MFC printers.','category'=>'Drivers','brand'=>'Brother','version'=>'2.8.5','size'=>'87 MB','os'=>'Windows 10/11','icon'=>'fa-print','downloads'=>5430],
            ['title'=>'HP Smart - Printer Management App','description'=>'Official HP app for printer management, mobile printing, and cloud scanning.','category'=>'Software','brand'=>'HP','version'=>'8.12.0','size'=>'156 MB','os'=>'Windows 10/11','icon'=>'fa-mobile-alt','downloads'=>23400],
            ['title'=>'Epson Print Layout','description'=>'Professional photo printing software for Epson printers.','category'=>'Software','brand'=>'Epson','version'=>'1.6.3','size'=>'64 MB','os'=>'Windows 10/11','icon'=>'fa-image','downloads'=>4320],
            ['title'=>'User Manual - HP LaserJet Pro','description'=>'Comprehensive user guide for HP LaserJet Pro Series printers.','category'=>'Manuals','brand'=>'HP','version'=>'1.0','size'=>'12 MB','os'=>'PDF','icon'=>'fa-file-pdf','downloads'=>6780],
            ['title'=>'Troubleshooting Guide - Canon PIXMA','description'=>'Detailed guide for resolving common Canon PIXMA issues.','category'=>'Manuals','brand'=>'Canon','version'=>'2.0','size'=>'8 MB','os'=>'PDF','icon'=>'fa-file-pdf','downloads'=>5120],
            ['title'=>'Logitech Options+','description'=>'Customization software for Logitech mice and keyboards.','category'=>'Software','brand'=>'Logitech','version'=>'1.52.0','size'=>'178 MB','os'=>'Windows 10/11','icon'=>'fa-mouse','downloads'=>18900],
            ['title'=>'urca Product Catalogue 2026','description'=>'Comprehensive catalogue of all urca products for 2026 with prices and specifications.','category'=>'Catalogues','brand'=>'urca','version'=>'2026','size'=>'24 MB','os'=>'PDF','icon'=>'fa-book','downloads'=>15670],
        ];

        foreach ($downloads as $d) {
            Download::updateOrCreate(
                ['title' => $d['title']],
                $d
            );
        }

        // ── About Stats ─────────────────────────────────────────────────────
        $stats = [
            ['number'=>'500+','label'=>'Products Available','label_ar'=>'منتج متاح','icon'=>'fa-box','sort_order'=>1],
            ['number'=>'15K+','label'=>'Happy Customers','label_ar'=>'عميل سعيد','icon'=>'fa-users','sort_order'=>2],
            ['number'=>'10+','label'=>'Years of Experience','label_ar'=>'سنوات خبرة','icon'=>'fa-award','sort_order'=>3],
            ['number'=>'24/7','label'=>'Tech Support','label_ar'=>'دعم فني','icon'=>'fa-headset','sort_order'=>4],
        ];

        foreach ($stats as $s) {
            AboutStat::updateOrCreate(
                ['label' => $s['label']],
                $s
            );
        }

        // ── About Team ──────────────────────────────────────────────────────
        $team = [
            ['name'=>'محمد أحمد','role'=>'CEO','role_ar'=>'المدير التنفيذي','bio'=>'15 years of experience in tech and computers','bio_ar'=>'15 سنة خبرة في التقنية وأجهزة الكمبيوتر','sort_order'=>1],
            ['name'=>'سارة علي','role'=>'Sales Manager','role_ar'=>'مدير المبيعات','bio'=>'Specialist in hardware and peripheral solutions','bio_ar'=>'متخصصة في حلول ملحقات وأجهزة الحواسيب','sort_order'=>2],
            ['name'=>'أحمد حسن','role'=>'Technical Support Manager','role_ar'=>'مدير الدعم الفني','bio'=>'Certified hardware and gaming tech specialist','bio_ar'=>'أخصائي معتمد في عتاد القيمنق والصوتيات','sort_order'=>3],
            ['name'=>'فاطمة محمود','role'=>'Marketing Manager','role_ar'=>'مدير التسويق','bio'=>'Expert in digital marketing and tech community','bio_ar'=>'خبيرة في التسويق الرقمي وبناء مجتمع التقنية','sort_order'=>4],
        ];

        foreach ($team as $t) {
            AboutTeam::updateOrCreate(
                ['name' => $t['name']],
                $t
            );
        }

        // ── About Values ────────────────────────────────────────────────────
        $values = [
            ['title'=>'Quality','title_ar'=>'الجودة الأصلية','description'=>"We only offer genuine products from the world's top brands.",'description_ar'=>'نقدم فقط منتجات أصلية من أفضل العلامات التجارية العالمية.','icon'=>'fa-star','sort_order'=>1],
            ['title'=>'Trust','title_ar'=>'الثقة والضمان','description'=>'We build long-term relationships grounded in transparency and integrity.','description_ar'=>'نبني علاقات طويلة الأمد مبنية على الشفافية والضمان الحقيقي.','icon'=>'fa-handshake','sort_order'=>2],
            ['title'=>'Innovation','title_ar'=>'أحدث التقنيات','description'=>"We stay ahead of the curve and bring cutting-edge solutions to our customers.",'description_ar'=>'نواكب أحدث التطورات ونقدم حلولاً متطورة لعملائنا.','icon'=>'fa-lightbulb','sort_order'=>3],
            ['title'=>'Support','title_ar'=>'الدعم المتواصل','description'=>'Our technical team is available around the clock to help you whenever you need.','description_ar'=>'فريقنا التقني متاح على مدار الساعة لمساعدتك في أي وقت.','icon'=>'fa-headset','sort_order'=>4],
        ];

        foreach ($values as $v) {
            AboutValue::updateOrCreate(
                ['title' => $v['title']],
                $v
            );
        }
    }
}
