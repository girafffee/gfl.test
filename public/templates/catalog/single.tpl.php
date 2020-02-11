
<!-- Button trigger modal -->
<button id="afterOrderBtn" style="display: none" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAfterOrder">
    Запустить модальное окно
</button>

<!-- Modal -->
<div class="modal fade" id="modalAfterOrder" tabindex="-1" role="dialog" aria-labelledby="modalAfterOrderlLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAfterOrderLabel">Спасибо за заказ!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="container" id="single-book">
    <div class="row">
        <div id="list-example" class="list-group col-md-4">
            <img src="/public/img/default.jpg" class="img-fluid" alt="Responsive image">
            <!-- Button trigger modal -->
            <button type="button" id="btn-book-order" class="btn btn-primary" data-toggle="modal" data-whatever="<?=$book['title']?>" data-target="#exampleModal">
                Заказать
            </button>
        </div>
        <div class="col-md-8">
            <h4 id="list-item-1">Название</h4>
            <p><?=$book['title']?></p>
            <h4 id="list-item-2">Жанры</h4>
            <p><?=$book['genres']?></p>
            <h4 id="list-item-3">Авторы</h4>
            <p><?=$book['authors']?></p>
            <h4 id="list-item-4">Краткое описание</h4>
            <p><?=$book['desc_short']?></p>
            <h4 id="list-item-3">Полное описание</h4>
            <p><?=$book['desc_full']?></p>

        </div>
    </div>
    <div class="card-footer text-muted">
        Дата публикации: <?=$book['created_at']?>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalTitle">Заказать</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-email" class="col-form-label">Ваш Email:</label>
                    <input type="email" class="form-control" name="email" id="recipient-email">
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Фио:</label>
                    <input type="text" class="form-control" name="fio" id="recipient-name">
                </div>
                <div class="form-group">
                    <label for="recipient-count" class="col-form-label">Колличество:</label>
                    <input type="number" class="form-control" name="count" id="recipient-count" min="1" max="15">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="orderBook(<?=$book['id']?>)">Save changes</button>
            </div>
        </div>
    </div>
</div>