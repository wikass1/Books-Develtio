<?php
get_header();


require_once plugin_dir_path(dirname(__FILE__)) . 'controllers/BooksController.php';

$controller = new BooksController();
$books_data = $controller->displayBooksArchive();


?>

    <section class="container mx-auto py-8 flex flex-wrap">
        <?php foreach ($books_data as $book): ?>
            <a href="<?php echo esc_url($book['link']); ?>" class="w-full md:w-1/2 p-2 h-100">
                <div class="overflow-hidden rounded-lg bg-white shadow mb-4 hover:shadow-md transition-shadow">
                    <img src="<?php echo esc_url($book['cover_image']); ?>" class="aspect-video w-full object-cover" alt="<?php echo esc_attr($book['title']); ?>" />

                    <div class="p-4">
                        <h2 class="text-xl font-medium text-gray-900"><?php echo esc_html($book['title']); ?></h2>
                        <div class="mt-4 flex gap-2">
                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2 py-1 text-xs font-semibold text-indigo-600">
                            Autor: <?php echo esc_html($book['acf_author']); ?>
                        </span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-600">
                            Gatunek: <?php echo esc_html($book['acf_genre']); ?>
                        </span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-lime-50 px-2 py-1 text-xs font-semibold text-lime-600">
                            Rok wydania: <?php echo esc_html($book['acf_publication_date']); ?>
                        </span>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </section>

<?php
get_footer();
?>