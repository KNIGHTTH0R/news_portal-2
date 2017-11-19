if (document.querySelector('meta[name="csrf-token"]') != null) {
    var csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

$('#alert').delay(3000).slideUp(300);

if (document.getElementById('delete') != undefined) {
    var action = document.getElementById('delete').action;
}

$('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    document.getElementById('delete').action = action + '/' + id;
});

if (document.querySelectorAll('[data-change-button]').length != 0){
    var change_buttons = document.querySelectorAll('[data-change-button]');

    for (let button of change_buttons){
        button.addEventListener('click', function () {

            var comment_text = document.getElementById('comment_textarea_id_' + this.getAttribute('data-comment-id')).value;

            var data = new FormData();
            data.set('_method', 'PATCH');
            data.set('_token', csrf_token);
            data.set('comment_id', this.getAttribute('data-comment-id'));
            data.set('body', comment_text);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/admin/comments-validation");
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onreadystatechange = function () {

                if (this.readyState != 4) return;

                var response = JSON.parse(this.responseText);

                if (this.status == 200) {
                }

                if (this.status == 422) {
                }
            };

            xhr.send(data);
        });
    }
}

if (document.querySelectorAll('[data-allowed-button]').length != 0){
    var allowed_buttons = document.querySelectorAll('[data-allowed-button]');

    for (let button of allowed_buttons){
        button.addEventListener('click', function () {

            var data = new FormData();
            var id = this.getAttribute('data-comment-id');

            data.set('_method', 'PUT');
            data.set('_token', csrf_token);
            data.set('comment_id', id);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/admin/comments-validation");
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onreadystatechange = function () {
                if (this.readyState != 4) return;

                if (this.status == 200) {
                    $('#comment_row_id_' + id).slideUp('slow');
                }

                if (this.status == 422) {
                }
            };

            xhr.send(data);
        });
    }
}

if (document.querySelectorAll('[data-delete-button]').length != 0){
    var delete_buttons = document.querySelectorAll('[data-delete-button]');

    for (let button of delete_buttons){
        button.addEventListener('click', function () {

            var data = new FormData();
            var id = this.getAttribute('data-comment-id');
            data.set('_method', 'DELETE');
            data.set('_token', csrf_token);
            data.set('comment_id', id);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/admin/comments-validation");
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onreadystatechange = function () {
                if (this.readyState != 4) return;

                if (this.status == 200) {
                    $('#comment_row_id_' + id).slideUp('slow');
                }

                if (this.status == 422) {
                }
            };

            xhr.send(data);
        });
    }
}

if (document.getElementById('select_all') != undefined){
    document.getElementById('select_all').addEventListener('click', function () {
        var checkboxes = document.querySelectorAll('[data-checkbox]');
        for (let checkbox of checkboxes){
              if (checkbox.checked == false){

                  checkbox.checked = true;

              } else if(checkbox.checked == true){

                  checkbox.checked = false;
              }
        }
    });
}

if (document.querySelector('[data-mass-allowed]') != undefined){
    document.querySelector('[data-mass-allowed]').addEventListener('click', function () {
       var checkboxes = document.querySelectorAll('[data-checkbox]');
       var ids = [];
       for (let checkbox of checkboxes){
           if (checkbox.checked == true) {
               ids.push(checkbox.value);
           }
       }

        var data = new FormData();
        var id = this.getAttribute('data-comment-id');

        data.set('ids', JSON.stringify(ids));
        data.set('_method', 'PUT');
        data.set('_token', csrf_token);


        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/admin/comments-validation/mass");
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function () {
            if (this.readyState != 4) return;

            if (this.status == 200) {
                window.location.reload();
            }

            if (this.status == 422) {
            }
        };

        xhr.send(data);
    });
}

if (document.querySelector('[data-mass-delete]') != undefined){
    document.querySelector('[data-mass-delete]').addEventListener('click', function () {
        var checkboxes = document.querySelectorAll('[data-checkbox]');
        var ids = [];
        for (let checkbox of checkboxes){
            if (checkbox.checked == true) {
                ids.push(checkbox.value);
            }
        }

        var data = new FormData();
        var id = this.getAttribute('data-comment-id');

        data.set('ids', JSON.stringify(ids));
        data.set('_method', 'DELETE');
        data.set('_token', csrf_token);


        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/admin/comments-validation/mass");
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function () {
            if (this.readyState != 4) return;

            if (this.status == 200) {
                window.location.reload();
            }

            if (this.status == 422) {
            }
        };

        xhr.send(data);
    });
}