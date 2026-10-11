<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MeetingType;
use App\Support\SeoMeta;
use App\Support\TextNormalizer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request, string $locale = 'fa')
    {
        $seo = new SeoMeta(
            title: $locale === 'fa' ? 'رزرو جلسه آنلاین و مشاوره تخصصی | امیرمحمد بحرلو' : 'Book a Technical Consultation | AmirMohammad Baharlou',
            description: $locale === 'fa'
                ? 'رزرو زمان جلسه ویدئویی جهت مشاوره فنی، بررسی نیازمندی‌های پروژه و بررسی امکان همکاری.'
                : 'Schedule a direct video meeting for technical scoping, architectural consultation, or project discovery.'
        );

        $meetingTypes = MeetingType::with('translations')
            ->where('is_active', true)
            ->get();

        return view('pages.booking', compact('seo', 'meetingTypes', 'locale'));
    }

    public function store(Request $request, string $locale = 'fa')
    {
        $validated = $request->validate([
            'meeting_type_id' => ['nullable', 'exists:meeting_types,id'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['required', 'email', 'max:255'],
            'client_phone' => ['nullable', 'string', 'max:50'],
            'slot_date' => ['required', 'date', 'after:today'],
            'slot_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $start = Carbon::parse($validated['slot_date'] . ' ' . $validated['slot_time']);
        $end = (clone $start)->addMinutes(30);

        // Atomic Concurrency Locking for Slot Reservation with strict overlap formula
        $appointment = DB::transaction(function () use ($validated, $start, $end) {
            $conflict = Appointment::where('status', '!=', 'cancelled')
                ->where(function ($q) use ($start, $end) {
                    $q->where('start_time', '<', $end)
                      ->where('end_time', '>', $start);
                })
                ->lockForUpdate()
                ->exists();

            if ($conflict) {
                return null;
            }

            return Appointment::create([
                'meeting_type_id' => $validated['meeting_type_id'] ?? null,
                'client_name' => TextNormalizer::normalize(strip_tags($validated['client_name'])),
                'client_email' => strtolower(trim($validated['client_email'])),
                'client_phone' => $validated['client_phone'] ? TextNormalizer::toEnglishDigits($validated['client_phone']) : null,
                'start_time' => $start,
                'end_time' => $end,
                'status' => 'confirmed',
                'notes' => $validated['notes'] ? strip_tags($validated['notes']) : null,
            ]);
        });

        if (! $appointment) {
            return redirect()->back()->withErrors([
                'slot_time' => $locale === 'fa' 
                    ? 'این بازه زمانی هم‌اکنون رزرو شده است. لطفاً ساعت دیگری را انتخاب نمایید.' 
                    : 'This time slot was just booked by another client. Please choose another slot.',
            ]);
        }

        return redirect()->back()->with('success', $locale === 'fa'
            ? 'جلسه شما با موفقیت رزرو و تایید گردید. لینک جلسه آنلاین برای ایمیل شما ارسال خواهد شد.'
            : 'Your meeting has been confirmed! Video call details have been sent to your email.');
    }
}
