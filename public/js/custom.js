$(document).ready(function(){

    /*$('.donation-data').on('click', ':not(.del-button)', function(){
        window.location.href = $(this).data('href');
    });*/

    
    /*$(".donation-data").click(function(e) {
        var del = $(".del-button");

        if (!$(e.target).hasClass('del-button')) 
        {
            if (!e.target.matches(del)) 
            {
                console.log("has !");
                window.location.href = $(this).data('href');
            }
        }
    });*/

});


function deleteData(x)
{
    var delbtn = $(x);
    
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this imaginary file!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.value) 
        {
          var td = delbtn.parent();    //get the parent of the button
          var form = td.children().last(); //get the form child element
          form.submit();                    //submit the form
          
        } else if (result.dismiss === Swal.DismissReason.cancel) 
        {
           
        }
      })
}

$(document).ready(function()
{
    $("#select-all-permissions").click(function () {
        $('.perm').not(this).prop('checked', this.checked);
    });

});
    
