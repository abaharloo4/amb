---
trigger: always_on
description: Mandatory frontend and backend security guardrails and standards for the AMB codebase
---

# Security Standards & Guardrails (AMB Platform)

All future developments and code modifications in this project MUST adhere strictly to the following security principles:

## 1. Backend Security Guardrails (Laravel / PHP / Database)
- **CSRF Verification**: All state-changing web endpoints (POST, PUT, DELETE) must validate CSRF tokens. Never disable VerifyCsrfToken middleware for user-facing routes.
- **Rate Limiting**: Protect sensitive endpoints (e.g. `/admin/login`, `/contact`, `/booking`, `/estimator/calculate`) against brute-force and spam using Laravel's rate limiters (`throttle:60,1` or stricter).
- **Concurrency & Locking**: For state transitions and reservations (e.g., Appointments/Booking), always use atomic database operations and `lockForUpdate()` inside DB transactions to prevent double-booking race conditions.
- **Input Sanitization & Mass Assignment**: Guard models with strict `$fillable` or `$guarded`. Validate every incoming request through Laravel FormRequests or explicit `$request->validate()`.
- **Zero-Exposure Secrets**: Never commit API keys, tokens, or plaintext passwords to git. Use `.env` and `.env.example` placeholders.
- **Security Headers**: All HTTP responses must include defensive headers (`X-Frame-Options`, `X-Content-Type-Options: nosniff`, `Referrer-Policy`, `X-XSS-Protection`).

## 2. Frontend Security Guardrails (Blade / JavaScript / Three.js / Alpine.js)
- **Strict Output Escaping (XSS Prevention)**: Never use unescaped Blade tags `{!! $userInput !!}` for any dynamic user-submitted content. Always use default `{{ $userInput }}` escaping.
- **Safe HTML / Markdown Rendering**: If rendering Markdown or rich text, pass content through a secure server-side sanitizer (e.g. HTMLPurifier / League CommonMark with safe options).
- **No Sensitive Local Storage**: Do not store authentication tokens, session secrets, or personal identifiable information (PII) in browser `localStorage` or `sessionStorage`. Store only non-sensitive visual preferences (e.g., `amb_theme`).
- **External Links Protection**: Any external link (`target="_blank"`) must include `rel="noopener noreferrer"`.
- **Canvas & WebGL Safety**: Isolate WebGL contexts properly and release GPU resources on scene teardown (`renderer.dispose()`) to prevent resource exhaustion.
