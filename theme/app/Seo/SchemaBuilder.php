<?php

namespace App\Seo;

class SchemaBuilder
{
    public static function register(): void
    {
        add_filter('wpseo_schema_graph', [self::class, 'addOrganization']);
        add_filter('wpseo_opengraph_url', [self::class, 'canonicalUrl']);
    }

    public static function addOrganization(array $graph): array
    {
        $address  = qazaqstan_option('address')       ?: 'пр. Достык, 308, Алматы';
        $phone    = qazaqstan_option('phone_primary')  ?: '+77272646454';
        $lat      = qazaqstan_option('map_lat')        ?: '43.2567';
        $lng      = qazaqstan_option('map_lng')        ?: '76.9286';

        foreach ($graph as &$node) {
            if (isset($node['@type']) && in_array($node['@type'], ['Organization', 'WebSite'], true)) {
                $node['@type'] = ['Organization', 'MedicalBusiness', 'LodgingBusiness'];
                $node['address'] = [
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => $address,
                    'addressLocality' => 'Алматы',
                    'addressRegion'   => 'Алматы',
                    'addressCountry'  => 'KZ',
                ];
                $node['telephone'] = sanitize_text_field($phone);
                $node['geo'] = [
                    '@type'     => 'GeoCoordinates',
                    'latitude'  => (float) $lat,
                    'longitude' => (float) $lng,
                ];
                $node['openingHoursSpecification'] = [
                    '@type'      => 'OpeningHoursSpecification',
                    'dayOfWeek'  => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],
                    'opens'      => '00:00',
                    'closes'     => '23:59',
                ];
                $node['priceRange'] = '₸₸';
            }
        }
        unset($node);

        if (is_singular('room')) {
            $post = get_queried_object();
            $price = (int) qazaqstan_field('room_price_single', $post->ID);
            $graph[] = [
                '@type'       => 'LodgingBusiness',
                '@id'         => get_permalink($post) . '#room',
                'name'        => $post->post_title,
                'description' => $post->post_excerpt,
                'url'         => get_permalink($post),
                'priceRange'  => $price ? qazaqstan_format_price($price) . '/сут.' : '₸₸',
            ];
        }

        if (is_singular('vacancy')) {
            $post     = get_queried_object();
            $salary   = qazaqstan_field('vacancy_salary', $post->ID);
            $deadline = qazaqstan_field('vacancy_deadline', $post->ID);
            $graph[] = array_filter([
                '@type'            => 'JobPosting',
                '@id'              => get_permalink($post) . '#job',
                'title'            => $post->post_title,
                'description'      => $post->post_content,
                'datePosted'       => get_the_date('Y-m-d', $post),
                'validThrough'     => $deadline ?: null,
                'hiringOrganization' => [
                    '@type' => 'Organization',
                    'name'  => 'АО «Санаторий Казахстан»',
                    'url'   => home_url('/'),
                ],
                'jobLocation' => [
                    '@type'   => 'Place',
                    'address' => [
                        '@type'           => 'PostalAddress',
                        'addressLocality' => 'Алматы',
                        'addressCountry'  => 'KZ',
                    ],
                ],
                'baseSalary' => $salary ? [
                    '@type'    => 'MonetaryAmount',
                    'currency' => 'KZT',
                    'value'    => $salary,
                ] : null,
            ]);
        }

        return $graph;
    }

    public static function canonicalUrl(string $url): string
    {
        return $url;
    }
}
