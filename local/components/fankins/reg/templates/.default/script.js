$(document).ready(function() {
    $("#reg").submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        BX.ajax.runComponentAction('fankins:reg',
            'sendForm', {
                mode: 'class',
                data: {post: formData},
            })
            .then(function(response) {
                alert(response.data.MESSAGE);
                location.reload();
            });
    });
});