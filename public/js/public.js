var csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
if (document.getElementById('send_comment') != null) {
    document.getElementById('send_comment').addEventListener('click', function () {


        formData = new FormData(form_comment);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/api/ajax/comment");
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function () {
            if (this.readyState != 4) return;
            var response = JSON.parse(this.responseText);

            if (this.status == 200) {

                    comment.className = 'form-control is-valid';
                    comment_error.style.display = 'none';

                    console.log(form_comment.getAttribute('data-status'));


                     if (response.parent_id != null) {
                         var ul = document.createElement("ul");
                         ul.setAttribute("class", "nested_comment");
                         ul.setAttribute("style", "display: none;");
                         ul.setAttribute("id", 'nested_comment_' + response.comment_id);
                         document.getElementById("comment_" + response.parent_id).appendChild(ul);


                         var li = document.createElement("li");
                         li.setAttribute("class", "comment");
                         li.setAttribute("style", "display: none;");
                         li.setAttribute("id", 'comment_' + response.comment_id);
                         document.getElementById("nested_comment_" + response.comment_id).appendChild(li);

                         var div_head = document.createElement("div");
                         div_head.setAttribute("class", "comment_head");
                         document.getElementById('nested_comment_' + response.comment_id).appendChild(div_head);

                         var div_body = document.createElement("div");
                         div_body.setAttribute("class", "comment_body");
                         document.getElementById('nested_comment_' + response.comment_id).appendChild(div_body);

                     } else {
                         var li = document.createElement("li");
                         li.setAttribute("class", "comment");
                         li.setAttribute("style", "display: none;");
                         li.setAttribute("id", 'comment_' + response.comment_id);
                         document.getElementById("comment_area").appendChild(li);

                         var div_head = document.createElement("div");
                         div_head.setAttribute("class", "comment_head");
                         document.getElementById('comment_' + response.comment_id).appendChild(div_head);

                         var div_body = document.createElement("div");
                         div_body.setAttribute("class", "comment_body");
                         document.getElementById('comment_' + response.comment_id).appendChild(div_body);



                         var hr = document.createElement("hr");
                         document.getElementById('comment_' + response.comment_id).appendChild(hr);
                     }




                    div_head.innerHTML = '<b>' + response.user_name + '</b> ' + response.time;

                    // var div_body = document.createElement("div");
                    // div_body.setAttribute("class", "comment_body");
                    // document.getElementById('comment_' + response.comment_id).appendChild(div_body);




                    div_body.innerHTML = response.comment;

                    comment.value = '';

                if (response.parent_id != null) {
                    var header = document.getElementById('form_comment_header');
                    header.parentNode.removeChild(header);

                    document.getElementById('form_comment_area').appendChild(form_comment);


                }

                if (response.parent_id != null) {

                    $('#nested_comment_' + response.comment_id).slideDown('slow');


                } else {

                    $('#comment_' + response.comment_id).slideDown('slow');
                }


            }

            if (response.errors != undefined) {

                if (Object.keys(response.errors).length != 0) {

                    comment_error.innerHTML = '';

                    for (let error in response.errors) {

                        comment_error.innerHTML += response.errors[error] + '<br>';
                    }

                    comment_error.style.display = 'block';
                    comment.className = 'form-control is-invalid';

                }
            }

        };

        xhr.send(formData);

    });
}

var spans = document.getElementsByClassName('reply');

for (let span of spans){
    span.addEventListener('click', function () {
        var reply_to = document.getElementById('comment_' + this.getAttribute('data-id')).getAttribute('data-owner');

        document.getElementById('comment_' + this.getAttribute('data-id')).appendChild(form_comment);
        comment.className = 'form-control';

        var input_parent_id = document.createElement("input");
        input_parent_id.setAttribute("type", "hidden");
        input_parent_id.setAttribute("name", "parent_id");
        input_parent_id.setAttribute("id", "parent_id");
        input_parent_id.setAttribute("value", this.getAttribute('data-id'));
        document.getElementById("form_comment").appendChild(input_parent_id);

        comment_error.style.display = 'none';
        form_comment.setAttribute('data-status', 'replying');
        comment.setAttribute('placeholder', 'Написать ответ пользователю - ' + reply_to);

        if (document.getElementById('form_comment_header') == null) {

            var header = document.createElement("h3");
            header.setAttribute("id", 'form_comment_header');
            header.innerHTML = 'Оставить комментарий';
            document.getElementById("form_comment_area").appendChild(header);

            header.addEventListener('click', function () {

                comment.className = 'form-control';
                comment_error.style.display = 'none';
                comment.value = '';
                comment.setAttribute('placeholder', 'Ваш комментарий');

                header.parentNode.removeChild(header);
                var parent_id = document.getElementById('parent_id');
                parent_id.parentNode.removeChild(parent_id);

                document.getElementById('form_comment_area').appendChild(form_comment);

            });
        }
});


}


var rate_up = document.querySelectorAll('[data-rate-up]');
var rate_down = document.querySelectorAll('[data-rate-down]');


for(let set_up of rate_up){
    set_up.addEventListener('click', function () {




        formData = new FormData();
        formData.set('rate', 1);
        formData.set('comment_id', set_up.getAttribute('data-id'));
        formData.set('_token', csrf_token);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/api/ajax/comment/rate/up");
        // xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function() {
            if (this.readyState != 4) return;
            var response = JSON.parse(this.responseText);
            document.getElementById('rate_up_comment_id_' + response.comment_id).innerHTML = response.rate.up;
            document.getElementById('rate_down_comment_id_' + response.comment_id).innerHTML = response.rate.down;



        };
        xhr.send(formData);
    });
}



for(let set_down of rate_down){
    set_down.addEventListener('click', function () {

        formData = new FormData();
        formData.set('rate', 0);
        formData.set('comment_id', set_down.getAttribute('data-id'));
        formData.set('_token', csrf_token);


        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/api/ajax/comment/rate/down");
        // xhr.withCredentials = true;
        // xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        // xhr.setRequestHeader('X-', 'XMLHttpRequest');


        xhr.onreadystatechange = function() {
            if (this.readyState != 4) return;
            var response = JSON.parse(this.responseText);

            document.getElementById('rate_down_comment_id_' + response.comment_id).innerHTML = response.rate.down;
            document.getElementById('rate_up_comment_id_' + response.comment_id).innerHTML = response.rate.up;



        };


        xhr.send(formData);
    });
}

var del_buttons = document.querySelectorAll('[data-del-comment]');

for(let del of del_buttons){

    del.addEventListener('click', function () {

        $('#comment_' + del.getAttribute('data-id')).slideUp('slow');

        formData = new FormData();

        formData.set('comment_id', del.getAttribute('data-id'));
        formData.set('_method', 'delete');
        formData.set('_token', csrf_token);

        var xhr = new XMLHttpRequest();
        xhr.open("post", "/api/ajax/comment/" + del.getAttribute('data-id'));
        // xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function() {
            if (this.readyState != 4) return;

            if (this.status == 200) {
                var del_visual = document.getElementById('comment_' + del.getAttribute('data-id'));
                del_visual.parentNode.removeChild(del_visual);
            }
                var response = JSON.parse(this.responseText);
        };
        xhr.send(formData);
    });
}




