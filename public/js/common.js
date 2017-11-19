if (document.getElementsByClassName('adv-price').length > 0){
    var adv_price = document.getElementsByClassName('adv-price');
    for (let price of adv_price){
        price.addEventListener('mouseover', function () {

           this.innerHTML = this.getAttribute('data-sale-price');

           var id = this.getAttribute('data-popover-id');
           document.getElementById('popover_id_' + id);
            $('#popover_id_' + id).slideDown('slow');
        });

        price.addEventListener('mouseout', function () {

            this.innerHTML = this.getAttribute('data-price');

            var id = this.getAttribute('data-popover-id');
            document.getElementById('popover_id_' + id);
            $('#popover_id_' + id).slideUp('slow');
        });
    }
}