let totalprice = 0;
let price = 0;
let countcheck = 0;
$( document ).ready(function() {

    $('.checkCategory').each(function() {
        $(this).click(function() {
            id = $(this).data('idx');
            isDiscount = $("#discount-"+id).val();
            if($('#formCheck-'+id).is(":checked")){
                totalprice += parseInt(($("#price-"+id).text()).substring(2));
                if(isDiscount !== 'N')
                    countcheck += 1;
                $("#list-category").append("<tr id='add-"+id+"'><td>"+$(this).val()+"</td></tr>");
            } else {
                totalprice -= parseInt(($("#price-"+id).text()).substring(2));
                if(isDiscount !== 'N')
                    countcheck -= 1;
                $("#add-"+id).remove();
            }
            $("#totalprice").text(totalprice+".00");
        
            if(countcheck >= 0 && countcheck < 3)
            {
                $("#discount").text(0+".00");  
            }
            else if(countcheck >= 3 && countcheck < 6){
                $("#discount").text(2+".00");  
            }
            else if(countcheck === 6){
                $("#discount").text(4+".00");  
            }
        
            $("#grandtotal").text(totalprice-$("#discount").text()+".00"); 
            $("#price").val($("#grandtotal").text());
        
        })
    })

    $("#formCheck-starter").click(function() {
        $("#plan-starter").removeClass("d-none");
    });

    $("#formCheck-pro").click(function() {
        $("#plan-starter").addClass("d-none");
    });
});



