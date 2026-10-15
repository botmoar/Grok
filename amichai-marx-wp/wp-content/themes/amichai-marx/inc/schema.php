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
                'description' => 'ייעוץ וליווי צמוד לכלכלת המשפחה ומשכנתאות: תקציב, יציאה מהמינוס, משכנתא, חסכונות והשקעות, פנסיה וביטוחים.',
                'url' => $home,
                'image' => amichai_portrait_url(),
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
                'founder' => ['@id' => $home . '#person'],
                'knowsLanguage' => 'he',
                'currenciesAccepted' => 'ILS',
            ],
            [
                '@type' => 'Person',
                '@id' => $home . '#person',
                'name' => 'עמיחי מרקס',
                'url' => home_url('/אודות/'),
                'image' => amichai_portrait_url(),
                'jobTitle' => 'יועץ לכלכלת המשפחה ויועץ משכנתאות',
                'worksFor' => ['@id' => $home . '#business'],
                'memberOf' => [
                    '@type' => 'Organization',
                    'name' => 'התאחדות יועצי המשכנתאות בישראל',
                ],
                'knowsLanguage' => 'he',
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

    $post_id = is_singular('post') ? get_queried_object_id() : 0;
    $post_slug = $post_id ? rawurldecode((string) get_post_field('post_name', $post_id)) : '';
    $is_mortgage = $post_id && ($post_slug === 'דיור-ומשכנתאות' || amichai_mortgage_topic($post_slug) !== null);

    if ($is_mortgage) {
        $data['@graph'][] = [
            '@type' => 'Service',
            '@id' => get_permalink($post_id) . '#service',
            'name' => wp_strip_all_tags(get_the_title($post_id)),
            'serviceType' => 'ייעוץ משכנתאות',
            'description' => wp_strip_all_tags((string) get_post_meta($post_id, '_amichai_meta_desc', true)),
            'url' => get_permalink($post_id),
            'provider' => ['@id' => $home . '#business'],
            'areaServed' => ['@type' => 'Country', 'name' => 'Israel'],
            'inLanguage' => 'he-IL',
        ];
        $faq = amichai_post_faq($post_id);
        if ($faq) {
            $data['@graph'][] = [
                '@type' => 'FAQPage',
                'mainEntity' => array_map(static fn (array $row): array => [
                    '@type' => 'Question',
                    'name' => $row['q'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $row['a']],
                ], $faq),
            ];
        }
    } elseif (is_singular('post')) {
        $data['@graph'][] = [
            '@type' => 'Article',
            'headline' => wp_strip_all_tags(get_the_title()),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'inLanguage' => 'he-IL',
            'mainEntityOfPage' => get_permalink(),
            'author' => ['@id' => $home . '#person'],
            'image' => get_the_post_thumbnail_url(null, 'large') ?: amichai_portrait_url(),
            'publisher' => ['@id' => $home . '#business'],
        ];
    }

    echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}, 20);
