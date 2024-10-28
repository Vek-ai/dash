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

  function delete(type, url, dataToDelete){
    $.ajax({
      type: type,
      url: url,
      data: dataToDelete.id,
      success: function (response) {
          $('#deleteResponseMessage').html('<div class="alert alert-' + (response.status === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
          $('#deleteModal').modal('show');

          // If successful, remove the drone from the table
          if (response.status === 'success') {
              $('button[data-id="' + droneIdToDelete + '"]').closest('tr').remove();
              droneIdToDelete = null; // Reset the ID after deletion

              // Close the modal after 3 seconds
              setTimeout(function () {
                  $('#deleteModal').modal('hide');
              }, 3000);
          }
      },
      error: function () {
          $('#deleteResponseMessage').html('<div class="alert alert-danger">An error occurred while deleting the drone.</div>');
          $('#deleteModal').modal('show');
      }
    });
  }
</script>