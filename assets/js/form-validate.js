(function () {
    'use strict'
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
  
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                var failed = false;
                // console.log($("[name='chkbox[]']:checked").length);
                
                if($("[name='package[]']:checked").val() == "Professional")
                {
                    $("[name='chkbox[]']").attr('required', false);
                    return false;
                }
                else if ($("[name='chkbox[]']:checked").length == 0) {
                    $("[name='chkbox[]']").attr('required', true);
                    failed = true;
                }
                else {
                    $("[name='chkbox[]']").attr('required', false);
                }
                
                if (failed === true) {
                    event.preventDefault()
                    event.stopPropagation()
                }
    
                form.classList.add('was-validated')
            }, false)
        })
})()