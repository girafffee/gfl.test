<?php if(empty($genres)): ?>
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
        <?php $count=0; foreach($genres as $genre): ?>
            <tr>
                <th scope="row"><?=++$count?></th>
                <td><?=$genre['name']?></td>
                <td><?=$genre['created_at']?></td>
                <td>
                    <a class="edit-author-btn" href="javascript:void(0)"
                       title="Edit" data-toggle="modal"
                       data-name="<?=$genre['name']?>"
                       data-id="<?=$genre['id']?>"
                       data-target="#exampleModalCenter"><i class="fas fa-edit"></i></a>

                    <a href="javascript:void(0)" title="Delete"
                       onclick="deleteAjax(<?=$genre['id']?>, '<?=$genre['name']?>', 'genre', callbackAjaxSuccess)">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>