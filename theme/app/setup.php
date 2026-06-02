<?php

namespace App;

use App\Fields\BookingRequestFields;
use App\Fields\ConferenceHallFields;
use App\Fields\DocumentFields;
use App\Fields\DoctorFields;
use App\Fields\GlobalOptionsFields;
use App\Fields\RoomFields;
use App\Fields\VacancyFields;
use App\PostTypes\Appeal;
use App\PostTypes\BookingRequest;
use App\PostTypes\ConferenceHall;
use App\PostTypes\Doctor;
use App\PostTypes\Document;
use App\PostTypes\Procedure;
use App\PostTypes\Room;
use App\PostTypes\Service;
use App\PostTypes\Testimonial;
use App\PostTypes\Vacancy;
use App\Taxonomies\Amenity;
use App\Taxonomies\DocType;
use App\Taxonomies\MedicalProfile;
use App\Taxonomies\RoomType;
use App\Forms\BookingHandler;
use App\Forms\AppealHandler;
use App\Forms\ApplyHandler;
use App\Seo\SchemaBuilder;
use App\Admin\Columns;
use App\Multilingual;
use App\Performance;
use Illuminate\Support\Facades\Vite;

require_once __DIR__ . '/helpers.php';

BookingHandler::register();
AppealHandler::register();
ApplyHandler::register();
SchemaBuilder::register();
Columns::register();
Multilingual::register();
Performance::register();

add_action('init', function () {
    Room::register();
    Doctor::register();
    Procedure::register();
    ConferenceHall::register();
    Service::register();
    Testimonial::register();
    Vacancy::register();
    Document::register();
    BookingRequest::register();
    Appeal::register();

    MedicalProfile::register();
    RoomType::register();
    Amenity::register();
    DocType::register();
}, 5);

add_action('wp_head', function () {
    printf(
        '<script>window.qazaqstanApi = %s;</script>',
        wp_json_encode([
            'root'  => esc_url_raw(rest_url('qazaqstan/v1/')),
            'nonce' => wp_create_nonce('wp_rest'),
        ])
    );
}, 5);

add_action('acf/init', function () {
    Options::register();
    RoomFields::register();
    DoctorFields::register();
    ConferenceHallFields::register();
    VacancyFields::register();
    DocumentFields::register();
    BookingRequestFields::register();
    GlobalOptionsFields::register();
});

add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');
    $settings['styles'][] = ['css' => "@import url('{$style}')"];
    return $settings;
});

add_action('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    if (! Vite::isRunningHot()) {
        $dependencies = json_decode(Vite::content('editor.deps.json'));
        foreach ($dependencies as $dependency) {
            if (! wp_script_is($dependency)) {
                wp_enqueue_script($dependency);
            }
        }
    }
    echo Vite::withEntryPoints(['resources/js/editor.js'])->toHtml();
});

add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

add_filter('should_load_separate_core_block_assets', '__return_false');

add_action('after_setup_theme', function () {
    remove_theme_support('block-templates');
    remove_theme_support('core-block-patterns');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('html5', [
        'caption', 'comment-form', 'comment-list',
        'gallery', 'search-form', 'script', 'style',
    ]);

    register_nav_menus([
        'primary'  => __('Основная навигация', 'qazaqstan'),
        'footer'   => __('Навигация в футере', 'qazaqstan'),
        'mobile'   => __('Мобильное меню', 'qazaqstan'),
    ]);

    load_theme_textdomain('qazaqstan', get_template_directory() . '/resources/lang');
}, 20);

add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ];

    register_sidebar([
        'name' => __('Блог — сайдбар', 'qazaqstan'),
        'id'   => 'sidebar-blog',
    ] + $config);
});
