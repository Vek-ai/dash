<script>
  function create(type, url, formData, formReset){
    $.ajax({
      type: type,
      url: url,
      data: formData,
      success: function (response) {
        // Parse the JSON response
        var jsonResponse = JSON.parse(response);

        if (jsonResponse.status === 'error') {                
            $('#responseMessage').html('<div class="alert alert-warning">' + jsonResponse.message + '</div>');
        } else {
            // Display the success message
            $('#responseMessage').html('<div class="alert alert-success">' + jsonResponse.message + '</div>');
            $(formReset)[0].reset(); // Reset the form after success 
        }
      }
    });
  }

</script>