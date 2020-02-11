window.onload = function () {
    $('#btn-book-order').click(function (event) {
        var button = $(event.target); // Button that triggered the modal
        var book = button.data('whatever'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        var modal = $('#exampleModal');
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        modal.find('.modal-title').text("Заказать " + book);
    });

    $('#exampleModal').on('show.bs.modal', function (event) {


        //modal.find('.modal-body input').val(recipient)
    });


    if(location.href.indexOf('catalog-g') === -1)
        return;

    var inputs = document.querySelectorAll("input.form-control");
    var values = location.href.split('catalog-g/')[1]; //.split('/');

    if(values.indexOf('?') !== -1)
    {
        values = values.split('?')[0].split('/');
    }
    else
    {
        values = values.split('/');
    }

    for(var i = 0; i < inputs.length; i++)
    {
        if(typeof values[i] === 'string')
            inputs[i].value = decodeURI(values[i]);
    }
};
function orderBook(book_info) {

    var data = {};
    var inputs = document.querySelectorAll("input.form-control");
    for(let i = 0; i < inputs.length; i++)
    {
        data[inputs[i].name] = inputs[i].value;
    }


    $.ajax({
        url: '/ajax/ajaxOrder',
        method: 'POST',
        data: {
            book: book_info,
            inp: data
        },
        success: function (data) {
            $('.modal-backdrop').remove();
            modalHide($('#exampleModal'));
            $('body').removeClass('modal-open');

            setTimeout(200);

            $('#afterOrderBtn').click()
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function modalHide(obj) {
    obj.removeClass('show').css('display','none').removeAttr('aria-modal').attr('aria-hidden', true);
}

function checkDelete(id, name) {
    var text = "Вы действительно хотите удалить '" + name + "'?";

    if(confirm(text))
    {
        location.href = "/admin-g/book/delete/" + id;
    }
}



function searchBooks(e)
{

    var values = [];
    var inputs = document.querySelectorAll("input.form-control");

    for(var i = 0; i < inputs.length; i++)
    {
        values[i] = inputs[i].value;
    }

    location.href = "/catalog-g/" + values.join('/');

}
