<?php
class BooksController {
    public function displayBooksArchive() {
        $books_data = array();
        $args = array(
            'post_type' => 'books',
            'posts_per_page' => -1,
        );
        $books_query = new WP_Query($args);

        if ($books_query->have_posts()) {
            while ($books_query->have_posts()) {
                $books_query->the_post();
                $books_data[] = array(
                    'acf_author' => get_field('autor') ?: 'brak danych',
                    'acf_publication_date' => get_field('rok_wydania') ?: 'brak danych',
                    'acf_genre' => get_field('gatunek') ?: 'brak danych',
                    'cover_image' => get_the_post_thumbnail_url(get_the_ID(), 'large') ?: plugin_dir_url(dirname(__FILE__)) . 'assets/img/example-book.jpg',
                    'publish_date' => get_the_date('j M Y'),
                    'title' => get_the_title(),
                    'description' => get_the_excerpt(),
                    'link' => get_permalink(),
                );
            }
            wp_reset_postdata();
        }

        return $books_data;
    }

    public function displaySingleBook() {
        if (!is_singular('books')) {
            return null;
        }

        the_post();

        $book_data = array(
            'acf_author' => get_field('autor') ?: 'brak danych',
            'acf_publication_date' => get_field('rok_wydania') ?: 'brak danych',
            'acf_genre' => get_field('gatunek') ?: 'brak danych',
            'cover_image' => get_the_post_thumbnail_url(get_the_ID(), 'large') ?: plugin_dir_url(dirname(__FILE__)) . 'assets/img/example-book.jpg',
            'publish_date' => get_the_date('j M Y'),
            'title' => get_the_title(),
            'description' => get_the_excerpt(),
            'link' => get_permalink(),
            'content' => get_the_content(),
        );

        wp_reset_postdata();

        return $book_data;
    }
}