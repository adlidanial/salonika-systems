$('#quick').click(function () {
    $('#form-message').removeAttr("class");
    let message = "Greeting\r\n\r\n";
    let status = $('#status').val();
    if(status === "0")
    {
        message += "We have received your order and we will" + 
        " update through your active email.";
    }
    else if(status === "1")
    {
        message += "We have processed your order and we will" + 
        " update through your active email when is done.";
    }
    else if(status === "2")
    {
        message += "We have complete your order and we have attach the result" + 
        " from your requested purchase. Kindly email us if any further question.";
    }
    message += "\r\n\r\nThank you."
    $('#message').text(message);
    $('#message').attr("readonly", "true");
})

$('#custom').click(function () {
    $('#form-message').removeAttr("class");
    $('#message').removeAttr("readonly");
    $('#message').text("");
})