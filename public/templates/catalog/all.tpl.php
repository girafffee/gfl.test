<?php
use Kernel\Router;
use App\Config;
use App\Base\BaseController;
?>
<section id="main">
    <div class="row">
        <div class="col-md-3" id="search" >
            <div class="container">
                <form action="" id="form">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Название или описание</span>
                        </div>
                        <input type="text" pattern="[a-zA-Zа-яА-Я]*" name="name-desc" class="form-control" id="input-name-desc" aria-describedby="basic-addon3">
                    </div>
                    <!--<div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3" >Жанр</span>
                        </div>
                        <input type="text" pattern="[a-zA-Zа-яА-Я]*" class="form-control" id="input-genre" aria-describedby="basic-addon3">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Автор</span>
                        </div>
                        <input type="text" pattern="[a-zA-Zа-яА-Я]*" class="form-control" id="input-author" aria-describedby="basic-addon3">
                    </div>-->

                    <h4 id="list-item-2">Жанры</h4>
                    <p class="row">
                        <?php foreach ($genres as $genre):?>
                            <div class="custom-control custom-checkbox my-1 col-4">
                                <input name="genres-<?=$genre['id']?>" class="custom-control-input form-control" type="checkbox"
                                       id="inlineGenre<?=$genre['id']?>" value="<?=$genre['id']?>">
                                <label class="custom-control-label" for="inlineGenre<?=$genre['id']?>"><?=$genre['name']?></label>
                            </div>
                        <?php endforeach; ?>
                    </p>

                    <h4 id="list-item-3">Авторы</h4>
                    <p>
                        <?php foreach ($authors as $author):?>
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input name="authors-<?=$author['id']?>" value="<?=$author['id']?>" type="checkbox" class="form-control custom-control-input" id="inlineAuthor<?=$author['id']?>">
                                <label class="custom-control-label" for="inlineAuthor<?=$author['id']?>"><?=$author['name']?></label>
                            </div>
                            <div class="w-100"></div>
                        <?php endforeach; ?>
                    </p>
                </form>
                <input type="button" class="btn btn-warning" value="Поиск" onclick="searchBooks()">
            </div>
        </div>

        <div class="col-md-9" id="catalog">
            <div class="container">

                <div class="row row-cols-1 row-cols-md-3" id="book-catalog">
                    <?php if(empty($books)): ?>
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                По данному запросу ничего не найдено
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($books as $book) : ?>

                            <div class="col mb-4">
                                <div class="card">
                                    <img src="<?=Config::img('default.png')?>" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary"><b>
                                                <a href="<?= Router::route('single_book', [
                                                    'action' => 'view',
                                                    'id' => $book['id']]) ?>"><?=$book['title']?></a>
                                            </b></h5>
                                        <p class="card-text"><b>Жанры</b>: <?=$book['genres']?></p>
                                        <p class="card-text"><b>Авторы</b>: <?=$book['authors']?></p>
                                        <p class="card-text"><b>Описание</b>: <?=$book['desc_short']?></p>

                                        <a href="<?=Router::route('single_book', [
                                                'action'    => 'view',
                                                'id'        => $book['id']])?>"
                                           class="btn btn-primary">Подробнее...</a>
                                        <?php if(BaseController::checkAdmin()): ?>
                                            <a href="javascript:void(0)" title="Delete" style="float: right;" class="btn btn-danger"
                                               onclick="checkDelete(<?=$book['id']?>, '<?=$book['title']?>')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>

                                            <a href="<?=Router::route('admin_single', [
                                                'object'    => 'book',
                                                'action'    => 'edit',
                                                'id'        => $book['id']
                                            ])?>"
                                            title="Edit" class="btn btn-secondary" style="float: right; margin-right: 5px;"><i class="fas fa-edit"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</section>