<?php
use Kernel\Router;
use App\Config;
use App\Base\BaseController;
?>

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
        </div><?php endforeach;?><?php endif;?>