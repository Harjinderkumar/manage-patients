<html>
<head>
  <?php include "header.php"; ?></head>
<body>
    <div class="container">
      <div id="alert-container"></div>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                      <h2>Manage <b>Patients</b></h2>
					          </div>
                    <div class="col-sm-6">
                      <a href="index.php?patient" class="btn btn-success" data-toggle="modal">
                        <i class="material-icons">&#xE147;</i> <span>Add New Patient</span>
                      </a>
                    </div>
                </div>
            </div>
            <?php 
              if(!empty($patients)) { ?>
                <form method="get" action="index.php" class="form-inline" style="margin-bottom:15px;">
                  <input type="hidden" name="action" value="patient_list">
                  <input type="hidden" name="sort" value="<?= $_GET['sort'] ?? '' ?>">
                  <input type="hidden" name="order" value="<?= $_GET['order'] ?? '' ?>">
                  <input type="text" name="search" class="form-control" placeholder="Search name" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                  <button type="submit" class="btn btn-success">Search</button>
                </form>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                          <th>
                            <span class="custom-checkbox">
                              <input type="checkbox" id="selectAll">
                              <label for="selectAll"></label>
                            </span>
                          </th>
                          <th>Date of submission</th>
                          <th>
                            <a href="index.php?action=patient_list&sort=first_name&search=<?= $_GET['search'] ?? '' ?>&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc'; ?>">
                              First Name
                              <i class="material-icons storing-icon-resize">
                                <?= ($_GET['order'] ?? 'asc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'; ?>
                              </i>
                            </a>
                          </th>
                          <th>Surname</th>
                          <th>
                            <a href="index.php?action=patient_list&sort=age&search=<?= $_GET['search'] ?? '' ?>&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc'; ?>">
                              Age
                              <i class="material-icons storing-icon-resize">
                                <?= ($_GET['order'] ?? 'asc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'; ?>
                              </i>
                            </a>
                          </th>
                          <th>
                            <a href="index.php?action=patient_list&sort=dob&search=<?= $_GET['search'] ?? '' ?>&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc'; ?>">
                              Date of Birth
                              <i class="material-icons storing-icon-resize">
                                <?= ($_GET['order'] ?? 'asc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'; ?>
                              </i>
                            </a>
                          </th>
                          <th>
                            <a href="index.php?action=patient_list&sort=total_score&search=<?= $_GET['search'] ?? '' ?>&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc'; ?>">
                              Total Score 
                              <i class="material-icons storing-icon-resize">
                                <?= ($_GET['order'] ?? 'asc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'; ?>
                              </i>
                            </a>
                          </th>
                          <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 
                      foreach($patients as $id => $data) { ?>
                        <tr data-id="<?= $data['id'] ?>">
                          <td>
                            <!-- <a href="./index.php?action=patient_view&patient_id=<?= $data['id'] ?>"> -->
                              <span class="custom-checkbox">
                                <input type="checkbox" id="checkbox1" name="options[]" value="1">
                                <label for="checkbox1"></label>
                              </span>
                            <!-- </a> -->
                          </td>
                          <td><?= $data['created_at']->format('d M Y'); ?> </td>
                          <td><?= $data['first_name']; ?> </td>
                          <td><?= $data['surname']; ?></td>
                          <td><?= $data['age']; ?></td>
                          <td><?= $data['dob']->format('d M Y'); ?></td>
                          <td><?= $data['total_score']; ?></td>
                          <td>
                              <a href="#editPatientModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit Patient">&#xE254;</i></a>
                              <a href="#deletePatientModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete Patient">&#xE872;</i></a>
                          </td>
                        </tr>
                      <?php }  
                      ?>
                    </tbody>
                </table>
              <?php
            } else {
              echo '<div class="text-center"><h1>Not found any Patient. Please add patient.</h1></div>';
            } ?>
        </div>
    </div>

    <!-- Edit Modal HTML -->
    <div id="editPatientModal" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div>
            <div class="modal-header">						
              <h4 class="modal-title">Edit Patient</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">					
              <?php 
                $form_id = 'patient_update_form';
                $is_show_question_panel = true; 
                include 'patient_form.php'; 
              ?>				
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Delete Modal HTML -->
    <div id="deletePatientModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="delete_form">
            <input name="patient_id" type="hidden" class="patient_id">
            <input name="method" type="hidden" value="DELETE">
            <div class="modal-header">						
              <h4 class="modal-title">Delete Patient</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">					
              <p>Are you sure you want to delete these Records?</p>
              <p class="text-warning"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
              <input type="submit" class="btn btn-danger" value="Delete">
            </div>
          </form>
        </div>
      </div>
    </div>
</body>
</html>