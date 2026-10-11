<?php

namespace App\Http\Controllers;

use App\Support\SeoMeta;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function services(Request $request, string $locale = 'fa')
    {
        $seo = new SeoMeta(
            title: $locale === 'fa' ? 'خدمات تخصصی مهندسی نرم‌افزار | امیرمحمد بحرلو' : 'Services & Capabilities | AmirMohammad Baharlou',
            description: $locale === 'fa' 
                ? 'خدمات توسعه سیستم‌های تحت وب، طراحی معماری مقیاس‌پذیر، پرفورمنس تیونینگ و پیاده‌سازی رابط‌های کاربری مدرن.'
                : 'Architectural consulting, full-stack application development, performance optimization, and custom 3D web interfaces.'
        );

        return view('pages.services', compact('seo', 'locale'));
    }

    public function resume(Request $request, string $locale = 'fa')
    {
        $seo = new SeoMeta(
            title: $locale === 'fa' ? 'رزومه و سوابق حرفه‌ای | امیرمحمد بحرلو' : 'Professional Resume & Career | AmirMohammad Baharlou',
            description: $locale === 'fa'
                ? 'سوابق کاری، مهارت‌های تخصصی، تحصیلات و مدارک امیرمحمد بحرلو؛ توسعه‌دهنده ارشد نرم‌افزار.'
                : 'Comprehensive work experience, skills breakdown, education, and achievements of AmirMohammad Baharlou.'
        );

        return view('pages.resume', compact('seo', 'locale'));
    }

    public function contact(Request $request, string $locale = 'fa')
    {
        $seo = new SeoMeta(
            title: $locale === 'fa' ? 'تماس و ثبت درخواست همکاری | امیرمحمد بحرلو' : 'Contact & Project Inquiries | AmirMohammad Baharlou',
            description: $locale === 'fa'
                ? 'راه‌های ارتباطی، مشاوره تخصصی و ثبت درخواست همکاری در پروژه‌های نرم‌افزاری.'
                : 'Get in touch for software projects, consulting, or engineering collaboration.'
        );

        return view('pages.contact', compact('seo', 'locale'));
    }
}
