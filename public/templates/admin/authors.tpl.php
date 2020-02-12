
<section class="container" id="admin-table">
    <h3 class="text-secondary d-flex justify-content-center">Авторы</h3>
    <form id="form">
        <div class="form-row align-items-center d-flex justify-content-center">
            <div class="col-sm-5 my-1">
                <label class="sr-only" for="inlineFormInputName">Name</label>
                <input type="text" class="form-control" name="name" id="inlineFormInputName" placeholder="Иван Иванов Иванович">
            </div>

            <div class="col-auto my-1">
                <input type="button" class="btn btn-success" onclick="objectAction('authors', 'create', callbackAjaxSuccess)" value="Добавить">
            </div>
        </div>
    </form>
    <div id="authors-table">
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
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Редактирование автора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form id="author-update">
                        <label for="author-name" class="col-form-label">ФИО:</label>
                        <input type="email" class="form-control" name="name" id="author-name">
                        <input type="hidden" name="id">
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" onclick="objectAction('authors', 'update', callbackAjaxSuccess, '#author-update')" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>
