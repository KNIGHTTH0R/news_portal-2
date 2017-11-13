$('#alert').delay(3000).slideUp(300);

var action = document.getElementById('delete').action;

$('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    document.getElementById('delete').action = action + '/' + id;
});