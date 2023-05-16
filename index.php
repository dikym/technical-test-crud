<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require("functions/functions.php");

$students = query("SELECT * FROM students");

if (isset($_POST["add_button"])) {
  add_student($_POST);
  header("location: ?message=student_add_success");
}

if (isset($_POST["search_button"])) {
  $keyword = $_POST["keyword"];
  $students = search_student($keyword);
}

if (isset($_POST["edit_button"])) {
  edit_student($_POST);
  header("location: ?message=student_edit_success");
}
?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technical Test Sekawan Media</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="d-flex flex-column h-100">
  <header>
    <?php
    if (isset($_GET["message"])) {
      if ($_GET['message'] == "delete_student_success") {
        echo "<div class='alert alert-success alert-dismissible fade show text-center m-0' role='alert'>
                Student deleted successfully!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close' onclick=\"location.href='index.php'\"></button>
              </div>";
      } else if ($_GET['message'] == "student_add_success") {
        echo "<div class='alert alert-success alert-dismissible fade show text-center m-0' role='alert'>
                Student added successfully!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close' onclick=\"location.href='index.php'\"></button>
              </div>";
      } else if ($_GET['message'] == "student_edit_success") {
        echo "<div class='alert alert-success alert-dismissible fade show text-center m-0' role='alert'>
                Student edited successfully!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close' onclick=\"location.href='index.php'\"></button>
              </div>";
      }
    }
    ?>
    <h1 class="text-center my-5">Data Siswa</h1>
  </header>

  <main class="container">
    <div class="d-flex justify-content-center">
      <div class="container table-responsive p-1">
        <div class="row mb-4 m-0">
          <div class="col-sm-8 p-0">
            <button class="btn btn-dark rounded-pill px-3 mb-2" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg"></i> Add New Student</button>
          </div>
          <div class=" col-sm-4 p-0">
            <form class="input-group" method="post">
              <input class="form-control border-dark-subtle rounded-pill" type="search" placeholder="Search" name="keyword">
              <button class="btn btn-dark rounded-pill px-3" type="submit" name="search_button"><i class=" bi bi-search"></i></button>
            </form>
          </div>
        </div>
        <?php if (isset($_POST["search_button"])) : ?>
          <span class="search-info"><?= mysqli_num_rows($students); ?> data found</span>
        <?php endif; ?>
        <div class="card table-responsive">
          <table class="table table-hover align-middle m-0">
            <thead class="table-light text-nowrap">
              <tr align="center">
                <th>id</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody class="text-nowrap">
              <?php if (mysqli_num_rows($students) > 0) : ?>
                <?php foreach ($students as $student) : ?>
                  <tr align="center">
                    <td><?= $student["id"]; ?></td>
                    <td><?= $student["nama"]; ?></td>
                    <td>
                      <?php if ($student["jenis_kelamin"] == "0") : ?>
                        <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill">Laki-laki</span>
                      <?php else : ?>
                        <span class="badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill">Perempuan</span>
                      <?php endif; ?>
                    </td>
                    <td><?= $student["alamat"]; ?></td>
                    <td>
                      <a href="#editModal" class="link-dark text-decoration-none me-3 btn-edit" data-bs-toggle="modal" data-id="<?= $student["id"]; ?>"><i class="bi bi-pencil-fill"></i></a><a href="delete_student.php?id=<?= $student["id"]; ?>" class="link-dark text-decoration-none" onclick="return confirm('Selected student data will delete permanently, are you sure?')"><i class="bi bi-trash3-fill"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="7" align="center"><em>Data not found</em></td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <section>
      <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form method="post" class="needs-validation" autocomplete="off" novalidate>
              <div class="modal-header bg-warning-subtle">
                <h4 class="modal-title text-black">Edit Student</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body bg-primary-subtle">
                <input type="hidden" name="id" id="id">
                <div class="form-group mb-3">
                  <label for="name" class="form-label">Nama</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                  <div class="invalid-feedback">
                    Please input student name.
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="gender" class="d-block form-label">Jenis Kelamin</label>
                  <select class="form-select" id="gender" name="gender" required>
                    <option selected disabled value="">Choose...</option>
                    <option value="0">Laki-laki</option>
                    <option value="1">Perempuan</option>
                  </select>
                  <div class="invalid-feedback">
                    Please select valid gender.
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="address" class="form-label">Alamat</label>
                  <textarea class="form-control" id="address" name="address" required></textarea>
                  <div class="invalid-feedback">
                    Please input student address.
                  </div>
                </div>
              </div>
              <div class="modal-footer bg-success-subtle">
                <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-dark rounded-pill px-3" name="edit_button">Edit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form method="post" class="needs-validation" autocomplete="off" novalidate>
              <div class="modal-header bg-warning-subtle">
                <h4 class="modal-title text-black">Add New Student</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body bg-primary-subtle">
                <div class="form-group mb-3">
                  <label for="name" class="form-label">Nama</label>
                  <input type="tert" class="form-control" id="name" name="name" required>
                  <div class="invalid-feedback">
                    Please input stundent name.
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="gender" class="d-block form-label">Jenis Kelamin</label>
                  <select class="form-select" id="gender" name="gender" required>
                    <option selected disabled value="">Choose...</option>
                    <option value="0">Laki-laki</option>
                    <option value="1">Perempuan</option>
                  </select>
                  <div class="invalid-feedback">
                    Please select valid gender.
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="address" class="form-label">Alamat</label>
                  <textarea class="form-control" id="address" name="address" required></textarea>
                  <div class="invalid-feedback">
                    Please input student address.
                  </div>
                </div>
              </div>
              <div class="modal-footer bg-success-subtle">
                <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-dark rounded-pill px-3" name="add_button">Add</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="text-center text-muted p-3 mt-auto">
    <span>Made with &#10084; by Diky</span>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
  <script src="assets/js/validation.js"></script>
  <script src="assets/js/student.js"></script>
</body>

</html>
