<?php
/**
 * LocalBusiness + ProfessionalService JSON-LD. Facts only, from the live site.
 */

defined('ABSPATH') || exit;

add_action('wp_head', function (): void {
    $home = home_url('/');
    $data = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => ['LocalBusiness', 'ProfessionalService'],
                '@id' => $home . '#business',
                'name' => 'עמיחי מרקס – ייעוץ לכלכלת המשפחה',
                'description' => 'ייעוץ וליווי לכלכלת המשפחה: תקציב, מינוס, משכנתא, פנסיה, ביטוחים וחסכונות.',
                'url' => $home,
                'image' => get_template_directory_uri() . '/assets/images/portrait.jpg',
                'logo' => get_template_directory_uri() . '/assets/images/logo.png',
                'telephone' => '+972-54-2372417',
                'email' => 'marx@amichai-marx.co.il',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'תל מנשה 11',
                    'addressLocality' => 'חיננית',
                    'addressCountry' => 'IL',
                ],
                'areaServed' => [
                    '@type' => 'Country',
                    'name' => 'Israel',
                ],
                'founder' => [
                    '@type' => 'Person',
                    'name' => 'עמיחי מרקס',
                    'jobTitle' => 'יועץ לכלכלת המשפחה',
                ],
                'knowsLanguage' => 'he',
                'currenciesAccepted' => 'ILS',
            ],
            [
                '@type' => 'WebSite',
                '@id' => $home . '#website',
                'url' => $home,
                'name' => 'עמיחי מרקס',
                'inLanguage' => 'he-IL',
                'publisher' => ['@id' => $home . '#business'],
            ],
        ],
    ];

    if (is_singular('post')) {
        $data['@graph'][] = [
            '@type' => 'Article',
            'headline' => wp_strip_all_tags(get_the_title()),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'inLanguage' => 'he-IL',
            'mainEntityOfPage' => get_permalink(),
            'author' => [
                '@type' => 'Person',
                'name' => 'עמיחי מרקס',
            ],
            'publisher' => ['@id' => $home . '#business'],
        ];
    }

    echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}, 20);
