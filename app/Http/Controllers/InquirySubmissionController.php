<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Support\Sanitizer;
use App\Support\TextNormalizer;
use Illuminate\Http\Request;

class InquirySubmissionController extends Controller
{
    public function store(Request $request, string $locale = 'fa')
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'service_type' => ['nullable', 'string', 'max:100'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Inquiry::create([
            'name' => TextNormalizer::normalize(strip_tags($validated['name'])),
            'email' => strtolower(trim($validated['email'])),
            'phone' => $validated['phone'] ? TextNormalizer::toEnglishDigits($validated['phone']) : null,
            'service_type' => $validated['service_type'] ?? 'general',
            'subject' => TextNormalizer::normalize(strip_tags($validated['subject'])),
            'message' => Sanitizer::cleanPlainText($validated['message']),
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'data' => [
                'locale' => $locale,
                'submitted_at' => now()->toIso8601String(),
            ]
        ]);

        return redirect()->back()->with('success', $locale === 'fa' 
            ? 'پیام شما با موفقیت ثبت شد. در اسرع وقت با شما تماس خواهم گرفت.' 
            : 'Your message has been received successfully. I will get back to you shortly.');
    }
}
