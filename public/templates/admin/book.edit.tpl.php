<div class="container" id="single-book">
    <form method="POST">
        <div class="row">
                <div id="list-example" class="list-group col-md-4">
                    <img src="/public/img/default.jpg" class="img-fluid" alt="Responsive image">
                    <input type="submit" value="Сохранить" class="btn btn-success">
                </div>
                <div class="col-md-8">

                    <h4 id="list-item-1">Название</h4>
                    <p>
                        <input type="text" name="title" class="form-control" value="<?=$books['title']?>" required>
                    </p>
                    <h4 id="list-item-2">Жанры</h4>
                    <p><?php $count = 0; ?>
                        <?php foreach ($genres as $genre): $count++;?>
                            <?php if(in_array($genre['id'], $books['genres'])): ?>
                                <input type="hidden" name="src[genre][]" value="<?=$genre['id']?>">
                            <?php endif; ?>
                            <div class="form-check form-check-inline">
                                <input name="upd[genre][]" class="form-check-input" type="checkbox"
                                       id="inlineGenre<?=$genre['id']?>" value="<?=$genre['id']?>"
                                        <?php if(in_array($genre['id'], $books['genres'])): ?>
                                            checked="checked"
                                        <?php endif;?>
                                        >
                                <label class="form-check-label" for="inlineGenre<?=$genre['id']?>"><?=$genre['name']?></label>
                            </div>
                            <?php if($count % 2 == 0): ?>
                                <div class="w-100"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </p>
                    <h4 id="list-item-3">Авторы</h4>
                    <p><?php $count = 0; ?>
                        <?php foreach ($authors as $author): $count++;?>
                            <?php if(in_array($author['id'], $books['authors'])): ?>
                                <input type="hidden" name="src[author][]" value="<?=$author['id']?>">
                            <?php endif; ?>
                            <div class="form-check form-check-inline">
                                <input name="upd[author][]" class="form-check-input" type="checkbox"
                                       id="inlineAuthor<?=$author['id']?>" value="<?=$author['id']?>"
                                                <?php if(in_array($author['id'], $books['authors'])): ?>
                                                    checked="checked"
                                                    <?php endif;?>
                                >
                                <label class="form-check-label" for="inlineAuthor<?=$author['id']?>"><?=$author['name']?></label>
                            </div>
                            <?php if($count % 2 == 0): ?>
                                <div class="w-100"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </p>
                    <h4 id="list-item-4">Краткое описание</h4>
                    <p>
                        <div class="mb-3">
                            <textarea name="desc_short"
                                class="form-control" id="desc_short" placeholder="Введите краткое описание" rows="3"><?=$books['desc_short']?></textarea>
                        </div>
                    </p>
                    <h4 id="list-item-3">Полное описание</h4>
                    <p>
                        <div class="mb-3">
                            <textarea name="desc_full"
                                class="form-control" id="desc_full" placeholder="Введите полное описание" rows="14"><?=$books['desc_full']?></textarea>
                        </div>
                    </p>

                </div>

        </div>
    </form>
    <div class="card-footer text-muted">
        Дата публикации: <?=$books['created_at']?>
    </div>
</div>
