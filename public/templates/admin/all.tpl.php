<?php
use Kernel\Router;
use App\Config;
?>
<section class="container" id="admin-table">
    <?php if(empty($books)): ?>
        <div class="alert alert-info" role="alert">
            Не добавлено еще ни одной книги
        </div>
    <?php else: ?>
    <table class="table table-hover" >
        <thead>
        <tr>
            <th scope="col"><a href="<?=Router::route('admin_single', [
                    'object'    => 'book',
                    'action'    => 'create',
                    'id'        => ''
                ])?>" style="text-decoration: none;" class="text-success">Добавить <i class="fas fa-plus-circle"></i></a></th>
            <th scope="col">#</th>
            <th scope="col">Название</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Действие</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($count = 0; $count < sizeof($books); $count++): ?>
            <tr>
                <td></td>
                <th scope="row"><?=$count + 1?></th>
                <td><?=$books[$count]['title']?></td>
                <td><?=$books[$count]['created_at']?></td>
                <td>
                    <a href="<?=Router::route('admin_single', [
                        'object'    => 'book',
                        'action'    => 'edit',
                        'id'        => $books[$count]['id']
                        ])?>"
                       title="Edit"><i class="fas fa-edit"></i></a>

                    <a href="javascript:void(0)" title="Delete"
                       onclick="checkDelete(<?=$books[$count]['id']?>, '<?=$books[$count]['title']?>')">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>

    <?php endif; ?>
</section>