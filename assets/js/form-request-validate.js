(function () {
    'use strict'
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
  
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                var invalidemail = false;
                var invalidphonenum = false;

                if($("#validationEmail").val().indexOf(".") == -1){
                    invalidemail = true;
                    $("#alertemail").removeClass("d-none");
                }

                if($("#validationEmail").val().indexOf(".") != -1){
                    invalidemail = false;
                    $("#alertemail").addClass("d-none");
                }

                if($.isNumeric($("#validationPhoneNumber").val())){
                    invalidphonenum = false;
                    $("#alertphonenum").addClass("d-none");
                }
                else{
                    invalidphonenum = true;
                    $("#alertphonenum").removeClass("d-none");
                }

                if (invalidemail === true || !form.checkValidity() || invalidphonenum === true) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()