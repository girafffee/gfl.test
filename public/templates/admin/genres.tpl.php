
<section class="container" id="admin-table">
    <h3 class="text-secondary d-flex justify-content-center">Жанры</h3>
    <form id="form">
        <div class="form-row align-items-center d-flex justify-content-center">
            <div class="col-sm-5 my-1">
                <label class="sr-only" for="inlineFormInputName">Name</label>
                <input type="text" class="form-control" name="name" id="inlineFormInputName" placeholder="Название жанра">
            </div>

            <div class="col-auto my-1">
                <input type="button" class="btn btn-success" onclick="objectAction('genres', 'create', callbackAjaxSuccess)" value="Добавить">
            </div>
        </div>
    </form>
    <div id="authors-table">
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
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Редактирование жанра</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form id="genres-update">
                        <label for="author-name" class="col-form-label">Название:</label>
                        <input type="email" class="form-control" name="name" id="author-name">
                        <input type="hidden" name="id">
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" onclick="objectAction('genres', 'update', callbackAjaxSuccess, '#genres-update')" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>
