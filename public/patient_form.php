<form action="#" method="POST" id="<?= $form_id ?>">
  <input name="patient_id" type="hidden" class="patient_id">
  <div class="panel panel-default">
    <div class="panel-heading">Patient Details</div>
    <div class="panel-body">					
      <div class="form-group col-md-6">
        <label>First name</label>
        <input name="first_name" type="text" class="form-control first_name" required>
      </div>
      <div class="form-group col-md-6">
        <label>Surname</label>
        <input name="surname" type="text" class="form-control surname" required>
      </div>
      <div class="form-group col-md-6">
        <label>Date of Birth</label>

        <div class="form-group required">
          <div class="input-group date_of_birth">
            <input type="text" class="form-control" name="dob" id="dob" required readonly>
            <div class="input-group-addon cursor-pointer">
              <span class="glyphicon glyphicon-calendar"></span>
            </div>
          </div>
        </div>

      </div>
      <div class="form-group col-md-6">
        <label>Age</label>
        <input type="number" name="age" class="form-control age" id="patient_age" readonly>
      </div>
    </div>
  </div>
  <?php
  if(isset($is_show_question_panel)) {
    ?>
    <input name="method" type="hidden" value="POST">
    <div class="panel panel-default">
      <div class="panel-heading">Brief Pain Inventory (BPI)</div>
      <div class="panel-body">					
        <div class="form-group col-md-4">
          <label>1. How much relief have pain treatments or medicaTons FROM THIS CLINIC provided?</label>
          <input type="number" placeholder="100" name="data[1]" id="question_1" min="0" max="100" class="form-control" required>
        </div>
        <?php 
        $bpi_questions = [
          "2" => "Please rate your pain based on the number that best describes your pain at it’s WORSTin the past week.",
          "3" => "Please rate your pain based on the number that best describes your pain at it’s LEAST in the past week.", 
          "4" => "Please rate your pain based on the number that best describes your pain on the Average.",
          "5" => "Q5 - Please rate your pain based on the number that best describes your pain that tells how much pain you have RIGHT NOW.",
          "6" => "Based on the number that best describes how during the past week pain has INTERFERED with your: General AcTvity.",
          "7" => "Based on the number that best describes how during the past week pain has INTERFERED with your: Mood.",
          "8" => "Based on the number that best describes how during the past week pain has INTERFERED with your: Walking ability.",
          "9" => "Based on the number that best describes how during the past week pain has INTERFERED with your: Normal work (includes work both outside the home and housework).",
          "10" => "Based on the number that best describes how during the past week pain has INTERFERED with your: RelaTonships with other people.",
          "11" => "Based on the number that best describes how during the past week pain has INTERFERED with your: Sleep.",
          "12" => "Based on the number that best describes how during the past week pain has INTERFERED with your: Enjoyment of life"
        ];
        foreach($bpi_questions as $key => $question) { ?>
          <div class="form-group col-md-4">
          <label><?= $key .". ". $question; ?></label>
          <input type="number" placeholder="10" name="data[<?= $key; ?>]" id="question_<?= $key; ?>" min="0" max="10" class="form-control bpi_question_score" required>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php
  } else {
    echo '<input name="method" type="hidden" value="PUT">';
  }?>

  <div class="panel panel-default">
    <div class="panel-heading">Total Score</div>
    <div class="panel-body">					
      <div class="form-group col-md-3">
        <input type="text" name="total_score" class="form-control total_score" value="0" readonly>
      </div>
    </div>
  </div>

  <div class="text-right">
    <input type="submit" class="btn btn-info" value="Save">
  </div>
</form>