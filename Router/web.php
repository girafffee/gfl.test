<?php

use Kernel\Router;


Router::add('/catalog', 'App\controllers\BookController')
    ->name('catalog');

Router::add('/admin', 'App\controllers\AdminController')
    ->name('admin');


Router::add('/', 'App\controllers\HomeController')
    ->name('home');


Router::addGroup('/catalog-g/{search_string}/{genre_id}/{author_id}', 'App\controllers\BookController#search')
    ->name('catalog_search');

Router::addGroup('/admin-g/{object}/{action}/{id}', 'App\controllers\AdminController')
    ->name('admin_single');

Router::addGroup('/book/{action}/{id}', 'App\controllers\BookController')
    ->name('single_book');

Router::addGroup('/ajax/{action}', 'App\controllers\AjaxBookController')
    ->name('ajax_book');

/**
 * SELECT b.id, b.title,
GROUP_CONCAT(DISTINCT g.name) as "genres",
GROUP_CONCAT(DISTINCT a.name) as "authors" FROM `book_genres` bg
LEFT JOIN books b ON bg.book_id = b.id
LEFT JOIN genres g ON bg.genre_id = g.id

LEFT JOIN book_authors ba ON ba.book_id = b.id
LEFT JOIN authors a ON ba.author_id = a.id
GROUP BY bg.book_id
 */

