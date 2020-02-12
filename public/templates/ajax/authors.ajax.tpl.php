<?php if(empty($authors)): ?>
    <div class="alert alert-info" role="alert">
        Не добавлено еще ни одного автора
    </div>
<?php else: ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ФИО</th>
            <th scope="col">Дата добавления</th>
            <th scope="col">Действие</th>
        </tr>
        </thead>
        <tbody>
        <?php $count=0; foreach($authors as $author): ?>
            <tr>
                <th scope="row"><?=++$count?></th>
                <td><?=$author['name']?></td>
                <td><?=$author['created_at']?></td>
                <td>
                    <a class="edit-author-btn" href="javascript:void(0)"
                       title="Edit" data-toggle="modal"
                       data-name="<?=$author['name']?>"
                       data-id="<?=$author['id']?>"
                       data-target="#exampleModalCenter"><i class="fas fa-edit"></i></a>

                    <a href="javascript:void(0)" title="Delete"
                       onclick="deleteAjax(<?=$author['id']?>, '<?=$author['name']?>', 'author', callbackAjaxSuccess)">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>