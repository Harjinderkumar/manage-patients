$(document).ready(function(){
      // Calculate the BPI Question Total Scores
      $(".bpi_question_score").on("input", function() {
        var total_score = 0;
        $(".bpi_question_score").each(function() {
          if($.isNumeric($(this).val())) {
            total_score = total_score + parseFloat($(this).val());
          }
        });
        $(".total_score").val(total_score);
      });

      // DD/MM/YYYY
      $('.date_of_birth').datetimepicker({
        format: 'L',
        ignoreReadonly: true
      }).on('dp.change', function (e) {
        var dob = e.date;
        if (dob) {
          var today = moment();
          var age = today.diff(dob, 'years');
          $('#patient_age').val(age);
        } else {
          $('#patient_age').val('');
        }
      });
      
      // SUBMIT FORM THROUGH AJAX
      $('#patient_form').submit(function(e){
        e.preventDefault();
        $.post('index.php?user_action=patient_create', $(this).serialize(), function(response){
            try {
              data = JSON.parse(response);
              alert(data.msg);
              $('#patient_form')[0].reset(); // RESET THE FORM AFTER SUBMISSION
          } catch (e) {
            alert("Response is not valid JSON:", e);
          }
        });
      });


    // SET ID WHEN MODAL OPENS
    $('#deletePatientModal').on('show.bs.modal', function (e) {
      var patient_id = $(e.relatedTarget).closest('tr').data('id'); // GET PATIENT ID
      $(this).find('.patient_id').val(patient_id); // SET PATIENT ID
    });

    // RESET ID WHEN MODAL CLOSES
    $('#deletePatientModal, #editPatientModal').on('hidden.bs.modal', function () {
        $(this).find('.patient_id').val(''); // RESET PATIENT ID
    });

    // DELETE THROUGH AJAX
    $('#delete_form').submit(function(e){
        e.preventDefault();
        $.post('index.php?action=patient_delete', $(this).serialize(), function(response){
            try {
                data = JSON.parse(response);
                alert(data.msg);
                location.reload();
            } catch (e) {
              alert("Response is not valid JSON:", e);
            }
        });
    });
    
    // GET AND LOAD PATIENT DATA
    $('#editPatientModal').on('show.bs.modal', function (e) {
      var patient_id = $(e.relatedTarget).closest('tr').data('id'); // GET PATIENT ID
      var modal_intance = $(this);
      modal_intance.find('.patient_id').val(patient_id); // SET PATIENT ID
      $.post('index.php?action=patient_get&patient_id='+patient_id, null, function(response){
          try {
              // modal_intance.find('.modal-body').html('').html(response);
              data = JSON.parse(response);
              modal_intance.find('.first_name').val(data.first_name);
              modal_intance.find('.surname').val(data.surname);
              modal_intance.find('.age').val(data.age);

              $.each(data.data, function(index, value) {
                modal_intance.find('#question_'+index).val(value);
              });

              $('.date_of_birth').data("DateTimePicker").date(moment(data.dob, 'MM-DD-YYYY'));

              modal_intance.find('.total_score').val(data.total_score);
              // console.log(modal_intance.find('.total_score'));
          } catch (e) {
            alert("Response is not valid JSON:", e);
          }
      });
      
    });
    // UPDATE PATIENT REQUEST
    $('#patient_update_form').submit(function(e){
        e.preventDefault();
        $.post('index.php?action=patient_update', $(this).serialize(), function(response){
            try {
                data = JSON.parse(response);
                alert(data.msg);
                location.reload();
            } catch (e) {
              alert("Response is not valid JSON:", e);
            }
        });
    });
  });