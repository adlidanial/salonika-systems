(function () {
    'use strict'
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
  
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                var failed = false;
                var alertcategory = false;
                // console.log($("[name='chkbox[]']:checked").length);
                if($("[name='package[]']:checked").length == 0)
                {
                    $("#alertplan").removeClass("d-none");
                }
                if($("[name='package[]']:checked").length > 0)
                {
                    $("#alertplan").addClass("d-none");
                }
                if($("[name='package[]']:checked").val() == "Professional")
                {
                    $("[name='chkbox[]']").attr('required', false);
                }
                if ($("[name='package[]']:checked").val() == "Starter" && $("[name='chkbox[]']:checked").length < 3) {
                    $("[name='chkbox[]']").attr('required', true);
                    failed = true;
                    alertcategory = true;
                }
                if ($("[name='package[]']:checked").val() == "Starter" && $("[name='chkbox[]']:checked").length >= 3) {
                    $("[name='chkbox[]']").attr('required', false);
                }
                if(alertcategory === true)
                    $("#alertcategory").removeClass("d-none");
                else
                    $("#alertcategory").addClass("d-none");


                if (failed === true || !form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()