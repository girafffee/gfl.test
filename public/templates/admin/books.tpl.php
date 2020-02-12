<?php
use Kernel\Router;
use App\Config;
use App\models\Books;
?>
<section class="container" id="admin-table">
    <?php if(empty($books)): ?>
        <div class="alert alert-info" role="alert">
            Не добавлено еще ни одной книги
        </div>
    <?php else: ?>
    <h3 class="text-secondary d-flex justify-content-center">Доступные книги &nbsp;<a href="<?=Router::route('admin_single', [
            'object'    => 'book',
            'action'    => 'create',
            'id'        => ''
        ])?>" style="text-decoration: none;" class="text-success"><i class="fas fa-plus-circle"></i></a></h3>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Название</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Действие</th>
        </tr>
        </thead>
        <tbody>
        <?php $count=0; foreach($books as $book): ?>
        <?php if($book['status'] == Books::STATUS_DELETED){continue;}?>
            <tr>
                <th scope="row"><?=++$count?></th>
                <td><?=$book['title']?></td>
                <td><?=$book['created_at']?></td>
                <td>
                    <a href="<?=Router::route('admin_single', [
                        'object'    => 'book',
                        'action'    => 'edit',
                        'id'        => $book['id']
                        ])?>"
                       title="Edit"><i class="fas fa-edit"></i></a>

                    <a href="javascript:void(0)" title="Delete"
                       onclick="checkDelete(<?=$book['id']?>, '<?=$book['title']?>')">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

        <h3 class="text-secondary d-flex justify-content-center">Удаленные книги &nbsp;<i class="text-danger fas fa-minus-circle"></i></h3>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Название</th>
                <th scope="col">Дата создания</th>
                <th scope="col">Действие</th>
            </tr>
            </thead>
            <tbody>
            <?php $count=0; foreach($books as $book): ?>
                <?php if($book['status'] == Books::STATUS_ACTIVE){continue;}?>
                <tr>

                    <th scope="row"><?=++$count?></th>
                    <td><?=$book['title']?></td>
                    <td><?=$book['created_at']?></td>
                    <td>
                        <a href="javascript:void(0)" title="Retrieve"
                           onclick="checkRetrieve(<?=$book['id']?>, '<?=$book['title']?>')">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>
</section>