<?php
get_header();

// Załaduj kontroler
require_once plugin_dir_path(dirname(__FILE__)) . 'controllers/BooksController.php';


$controller = new BooksController();
$book_data = $controller->displaySingleBook();

if ($book_data):
    ?>
    <div class="max-w-screen-lg mx-auto">
        <main class="mt-10">
            <div class="mb-4 md:mb-0 w-full mx-auto relative">
                <div class="mb-4 md:mb-0 w-full mx-auto relative">
                    <img src="<?php echo esc_url($book_data['cover_image']); ?>" class="w-full object-cover lg:rounded" style="height: 28em;"/>

                    <div class="absolute bottom-0 left-0 ml-4 mb-4">
                        <div class="flex gap-2">
                            <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2 py-1 text-xs font-semibold text-indigo-600">
                            Autor: <?php echo esc_html($book_data['acf_author']); ?>
                        </span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-600">
                            Gatunek: <?php echo esc_html($book_data['acf_genre']); ?>
                        </span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-lime-50 px-2 py-1 text-xs font-semibold text-lime-600">
                            Rok wydania: <?php echo esc_html($book_data['acf_publication_date']); ?>
                        </span>

                        </div>
                    </div>
                </div>

                <div class="px-4 lg:px-0">
                    <h2 class="text-4xl font-semibold text-gray-800 leading-tight">
                        <?php echo esc_html($book_data['title']); ?>
                    </h2>
                    <a href="<?php echo get_post_type_archive_link('books'); ?>" class="py-2 bg-green text-green-700 inline-flex items-center justify-center mt-2">
                        Wróć do listy książek
                    </a>
                </div>
            </div>
            <div class="flex flex-col lg:flex-row lg:space-x-12">
                <div class="px-4 lg:px-0 mt-12 text-gray-700 text-lg leading-relaxed w-full lg:w-3/4">
                    <?php echo $book_data['content']; ?>
                </div>
            </div>
        </main>
    </div>
<?php
endif;

get_footer();
?>