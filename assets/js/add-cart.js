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
});
// $('#formCheck').click(function (){
//     if($('#formCheck').is(":checked")){
//         console.log($('#price').text());
//         totalprice += $('#price').val();
//         countcheck += 1;
//         $("#list-category").append("<tr id='add-type'><td>Type</td></tr>");
//     } else {
//         totalprice -= 4;
//         countcheck -= 1;
//         $("#add-type").remove();
//     }
//     $("#totalprice").text(totalprice+".00");

//     if(countcheck >= 0 && countcheck < 3)
//     {
//         $("#discount").text(0+".00");  
//     }
//     else if(countcheck >= 3 && countcheck < 6){
//         $("#discount").text(2+".00");  
//     }
//     else if(countcheck === 6){
//         $("#discount").text(4+".00");  
//     }

//     $("#grandtotal").text(totalprice-$("#discount").text()+".00"); 
//     $("#price").val($("#grandtotal").text());

// });

// $('#formCheck-type').click(function (){
//     if($('#formCheck-type').is(":checked")){
//         totalprice += 4;
//         countcheck += 1;
//         $("#list-category").append("<tr id='add-type'><td>Type</td></tr>");
//     } else {
//         totalprice -= 4;
//         countcheck -= 1;
//         $("#add-type").remove();
//     }
//     $("#totalprice").text(totalprice+".00");

//     if(countcheck >= 0 && countcheck < 3)
//     {
//         $("#discount").text(0+".00");  
//     }
//     else if(countcheck >= 3 && countcheck < 6){
//         $("#discount").text(2+".00");  
//     }
//     else if(countcheck === 6){
//         $("#discount").text(4+".00");  
//     }

//     $("#grandtotal").text(totalprice-$("#discount").text()+".00"); 
//     $("#price").val($("#grandtotal").text());

// });

// $('#formCheck-material').click(function (){
//     if($('#formCheck-material').is(":checked")){
//         totalprice += 4;
//         countcheck += 1;
//         $("#list-category").append("<tr id='add-material'><td>Material</td></tr>");
//     } else {
//         totalprice -= 4;
//         countcheck -= 1;
//         $("#add-material").remove();
//     }  
//     $("#totalprice").text(totalprice+".00");

//     if(countcheck >= 0 && countcheck < 3)
//     {
//         $("#discount").text(0+".00");  
//     }
//     else if(countcheck >= 3 && countcheck < 6){
//         $("#discount").text(2+".00");  
//     }
//     else if(countcheck === 6){
//         $("#discount").text(4+".00");  
//     }

//     $("#grandtotal").text(totalprice-$("#discount").text()+".00"); 
//     $("#price").val($("#grandtotal").text());

// });

// $('#formCheck-price').click(function (){
//     if($('#formCheck-price').is(":checked")){
//         totalprice += 4;
//         countcheck += 1;
//         $("#list-category").append("<tr id='add-price'><td>Price Top 20 Seller</td></tr>");
//     } else {
//         totalprice -= 4;
//         countcheck -= 1;
//         $("#add-price").remove();
//     }
//     $("#totalprice").text(totalprice+".00");

//     if(countcheck >= 0 && countcheck < 3)
//     {
//         $("#discount").text(0+".00");  
//     }
//     else if(countcheck >= 3 && countcheck < 6){
//         $("#discount").text(2+".00");  
//     }
//     else if(countcheck === 6){
//         $("#discount").text(4+".00");  
//     }

//     $("#grandtotal").text(totalprice-$("#discount").text()+".00"); 
//     $("#price").val($("#grandtotal").text());

// });

// $('#formCheck-colour').click(function (){
//     if($('#formCheck-colour').is(":checked")){
//         totalprice += 4;
//         countcheck += 1;
//         $("#list-category").append("<tr id='add-colour'><td>Colour</td></tr>");
//     } else {
//         totalprice -= 4;
//         countcheck -= 1;
//         $("#add-colour").remove();
//     }
//     $("#totalprice").text(totalprice+".00");

//     if(countcheck >= 0 && countcheck < 3)
//     {
//         $("#discount").text(0+".00");  
//     }
//     else if(countcheck >= 3 && countcheck < 6){
//         $("#discount").text(2+".00");  
//     }
//     else if(countcheck === 6){
//         $("#discount").text(4+".00");  
//     }

//     $("#grandtotal").text(totalprice-$("#discount").text()+".00"); 
//     $("#price").val($("#grandtotal").text());

// });

// $('#formCheck-seller').click(function (){
//     if($('#formCheck-seller').is(":checked")){
//         totalprice += 4;
//         countcheck += 1;
//         $("#list-category").append("<tr id='add-seller'><td>Seller Top 20</td></tr>");
//     } else {
//         totalprice -= 4;
//         countcheck -= 1;
//         $("#add-seller").remove();
//     }
//     $("#totalprice").text(totalprice+".00");

//     if(countcheck >= 0 && countcheck < 3)
//     {
//         $("#discount").text(0+".00");  
//     }
//     else if(countcheck >= 3 && countcheck < 6){
//         $("#discount").text(2+".00");  
//     }
//     else if(countcheck === 6){
//         $("#discount").text(4+".00");  
//     }
    
//     $("#grandtotal").text(totalprice-$("#discount").text()+".00"); 
//     $("#price").val($("#grandtotal").text());

// });

// $('#formCheck-size').click(function (){
//     if($('#formCheck-size').is(":checked")){
//         totalprice += 4;
//         countcheck += 1;
//         $("#list-category").append("<tr id='add-size'><td>Size</td></tr>");
//     } else {
//         totalprice -= 4;
//         countcheck -= 1;
//         $("#add-size").remove();
//     }
//     $("#totalprice").text(totalprice+".00");

//     if(countcheck >= 0 && countcheck < 3)
//     {
//         $("#discount").text(0+".00");  
//     }
//     else if(countcheck >= 3 && countcheck < 6){
//         $("#discount").text(2+".00");  
//     }
//     else if(countcheck === 6){
//         $("#discount").text(4+".00");  
//     }

//     $("#grandtotal").text(totalprice-$("#discount").text()+".00");
//     $("#price").val($("#grandtotal").text());

// });

// $('#formCheck-comment').click(function (){
//     if($('#formCheck-comment').is(":checked")){
//         totalprice += 30;
//         $("#list-category").append("<tr id='add-comment'><td>Comment ( Seller Top 20, Quality Product, Customer Service )</td></tr>");
//     } else {
//         totalprice -= 30;
//         $("#add-comment").remove();
//     }
//     $("#totalprice").text(totalprice+".00");

//     if(countcheck >= 0 && countcheck < 3)
//     {
//         $("#discount").text(0+".00");  
//     }
//     else if(countcheck >= 3 && countcheck < 6){
//         $("#discount").text(2+".00");  
//     }
//     else if(countcheck === 6){
//         $("#discount").text(4+".00");  
//     }

//     $("#grandtotal").text(totalprice-$("#discount").text()+".00");
//     $("#price").val($("#grandtotal").text());

// });


