<?php
/**
 * Plugin Name: Books
 * Description: Zadanie rekrutacyjne Develtio - Wiktor Śmiech.
 */


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/controllers/BooksController.php';
require_once __DIR__ . '/models/Book.php';

class Books
{
    public function __construct()
    {
        add_action('init', array($this, 'registerBooksCPT'));
        add_action('acf/init', array($this, 'registerACFFields'));
        add_action('template_include', array($this, 'loadBookTemplates'));
        add_action('wp_enqueue_scripts', array($this, 'loadAssets'));
        add_action('tgmpa_register', array($this, 'registerRequiredPlugins'));
    }

    public function loadBookTemplates($template)
    {
        if (is_post_type_archive('books')) {
            $archiveTemplate = plugin_dir_path(__FILE__) . 'views/BooksArchiveView.php';
            if (file_exists($archiveTemplate)) {
                return $archiveTemplate;
            }
        } elseif (is_singular('books')) {
            $singleTemplate = plugin_dir_path(__FILE__) . 'views/SingleBookView.php';
            if (file_exists($singleTemplate)) {
                return $singleTemplate;
            }
        }
        return $template;
    }


    public function checkACFActivation()
    {
        if (!class_exists('ACF')) {
            add_action('admin_notices', array($this, 'showACFError'));
            deactivate_plugins(plugin_basename(__FILE__));
        }
    }

    public function registerBooksCPT()
    {
        $args = [
            'public' => true,
            'label' => 'Books',
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
        ];
        register_post_type('books', $args);
    }

    public function registerACFFields()
    {
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_1', // Unikalny klucz dla grupy pól
                'title' => 'Szczegóły Książki',
                'fields' => array(
                    array(
                        'key' => 'field_1',
                        'label' => 'Autor',
                        'name' => 'autor',
                        'type' => 'text',
                        'instructions' => 'Dodaj autora książki.',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_2',
                        'label' => 'Rok Wydania',
                        'name' => 'rok_wydania',
                        'type' => 'date_picker',
                        'instructions' => 'Podaj rok wydania książki.',
                        'required' => 1,
                        'display_format' => 'Y', // Format wyświetlania tylko rok
                        'return_format' => 'Y', // Format zwracany do PHP
                        'first_day' => 1, // Pierwszy dzień tygodnia (1 dla poniedziałku)
                    ),

                    array(
                        'key' => 'field_3',
                        'label' => 'Gatunek',
                        'name' => 'gatunek',
                        'type' => 'text',
                        'instructions' => 'Dodaj gatunek książki.',
                        'required' => 0,
                    )
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'books',
                        ),
                    ),
                ),
            ));

        endif;
    }

    public function loadAssets()
    {
        if (is_post_type_archive('books') || is_singular('books')) {
            wp_enqueue_style('books-plugin-css', plugin_dir_url(__FILE__) . 'assets/css/style.css');
            wp_enqueue_script('books-plugin-js', plugin_dir_url(__FILE__) . 'assets/js/script.js', array(), false, true);
            wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com');
        }
    }

    function registerRequiredPlugins()
    {
        $plugins = array(
            array(
                'name' => 'Advanced Custom Fields',
                'slug' => 'advanced-custom-fields',
                'required' => true,
            ),
        );

        $config = array(
            'id' => 'books-plugin',
            'default_path' => '',
            'menu' => 'tgmpa-install-plugins',
            'has_notices' => true,
            'dismissable' => true,
            'is_automatic' => false,
            'message' => '',
        );

        tgmpa($plugins, $config);
    }

}

new Books();
