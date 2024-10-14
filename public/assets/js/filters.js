$(function () {
    // Event listeners
    $(document).on('click', '#clear-filters', function(e) {
        e.preventDefault();
        window.location.href = '/' + $(this).attr('data-view')
    });
    $(document).on('click', '.column-sorter', function () {
        updateView($(this).attr('data-sort'));
    });
    $(document).on('change', '#filters input, #filters select', function() {
        updateView('');
    });

    // this one handles the ajax toggle of a task's status
    $(document).on('click', '.c-pointer', function() {
        $.ajax({
            type: 'PATCH',
            url: '/tasks/toggle/' + $(this).attr('data-id'),
            data: {
                _token: $('#csrf_token').val(),
                id: $(this).attr('data-id')
            },
            success: function(response) {
                $('[data-id="' + response.id + '"]').prop('src', response.imgSrc);
                $('[data-status="' + response.id + '"]').text(response.statusText);

                let statusFilter = $('#statusFilter').val();
                console.log(statusFilter);
                console.log(response.status);
                if (statusFilter !== '' && (response.status !== parseInt(statusFilter))) {
                    $('#row-' + response.id).remove();
                }
            },
        })
    });
});

function updateView(sort){
    let query_string = '?';
    $('#filters input, #filters select').each(function() {
        if($(this).val() != '') {
            query_string += $(this).attr('data-field') + '=' + $(this).val() + '&';
        }
    });
    query_string += 'sort=' + sort + '&sort_order=' + sortOrder();
    window.location.href = '/' + $('#page').val() + query_string;
}

function sortOrder(){
    let sort_icon =  $('#sort_icon').val();
    if (sort_icon !== '') {
        return sort_icon == 'up' ? 'asc' : 'desc';
    }
    return 'asc';
}
