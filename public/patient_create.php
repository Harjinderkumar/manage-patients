<html>
  <head>
    <?php include "header.php"; ?>
  </head>
  <body>
    <div class="">
      <div class="container">
        <div id="alert-container"></div>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                      <h2>Neuromodulaion</h2>
					          </div>
                     <div class="col-sm-6">
                        <a href="./index.php?action=patient_list" class="btn btn-success" >
                          <i class="material-icons">&#xe851;</i> <span>Admin View</span>
                        </a>
					          </div>
                </div>
            </div>
            <div>
              <?php 
                $form_id = 'patient_form';
                $is_show_question_panel = true; 
                include 'patient_form.php'; 
              ?>
            </div>
        </div>
      </div>
    </div>
  </body>
</html>