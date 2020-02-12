<?php
use Kernel\Router;
?>
<section id="admin-table" class="container">
    <div class="d-flex justify-content-around align-items-center">
        <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
            <div class="card-header">Управление книгами</div>
            <div class="card-body">
                <h5 class="card-title">Primary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="<?=Router::route('admin_group', [
                    'object'    => 'books',
                    'action'    => 'view'
                ])?>" class="btn btn-light">Перейти...</a>
            </div>
        </div>
        <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
            <div class="card-header">Управление авторами</div>
            <div class="card-body">
                <h5 class="card-title">Secondary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="<?=Router::route('admin_group', [
                    'object'    => 'authors',
                    'action'    => 'view'
                ])?>" class="btn btn-light">Перейти...</a>
            </div>
        </div>
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Управление жанрами</div>
            <div class="card-body">
                <h5 class="card-title">Success card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="<?=Router::route('admin_group', [
                    'object'    => 'genres',
                    'action'    => 'view'
                ])?>" class="btn btn-light">Перейти...</a>
            </div>
        </div>
    </div>
</section>