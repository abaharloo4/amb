<?php

namespace App\Support;

class SeoMeta
{
    public function __construct(
        public string $title = 'امیرمحمد بحرلو | Senior Full-Stack Engineer & Architect',
        public string $description = 'پرتفولیو و پلتفرم تخصصی امیرمحمد بحرلو؛ توسعه‌دهنده ارشد فول‌استک و معمار سیستم‌های مقیاس‌پذیر بر بستر PHP/Laravel، فرانت‌اند مدرن، Three.js و رایانش ابری.',
        public ?string $canonical = null,
        public ?string $ogImage = null,
        public string $type = 'website',
        public array $breadcrumbs = [],
        public array $schemaData = []
    ) {
        $this->canonical = $this->canonical ?? url()->current();
        $this->ogImage = $this->ogImage ?? asset('images/og-cover.png');
    }

    public function generateStructuredData(): string
    {
        $baseSchema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Person',
                    '@id' => url('/') . '/#person',
                    'name' => 'AmirMohammad Baharlou',
                    'alternateName' => 'امیرمحمد بحرلو',
                    'jobTitle' => 'Senior Full-Stack Engineer & System Architect',
                    'url' => url('/'),
                    'sameAs' => [
                        'https://github.com/abaharloo4',
                        'https://linkedin.com/in/abaharlou',
                    ],
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => url('/') . '/#website',
                    'url' => url('/'),
                    'name' => 'AMB Platform',
                    'publisher' => [
                        '@id' => url('/') . '/#person',
                    ],
                ]
            ]
        ];

        if (! empty($this->schemaData)) {
            $baseSchema['@graph'][] = $this->schemaData;
        }

        return json_encode(
            $baseSchema, 
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_PRETTY_PRINT
        );
    }
}
