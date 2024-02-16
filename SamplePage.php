<?php include "./dbinfo.inc.php"; ?>
<html>

<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
  </script>
</head>

<body>
  <div class="container-fluid">

    <h1>Data Siswa</h1>
    <hr>
    <?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  /* Ensure that the EMPLOYEES table exists. */
  VerifyEmployeesTable($connection, DB_DATABASE);

  /* If input fields are populated, add a row to the EMPLOYEES table. */
  $employee_del = (empty($_POST['del'])) ? '' : htmlentities($_POST['del']);
  $employee_id = (empty($_POST['ID'])) ? '' : htmlentities($_POST['ID']);
  $employee_name = (empty($_POST['NAME'])) ? '' : htmlentities($_POST['NAME']);
  $employee_address =  (empty($_POST['ADDRESS'])) ? '' : htmlentities($_POST['ADDRESS']);

  if (strlen($employee_id)) {
      if ($employee_del == 'delete') {
        DeleteEmployee($connection, $employee_id);
      } else {
        EditEmployee($connection, $employee_name, $employee_address, $employee_id);
      }
  } else {
    if (strlen($employee_name) || strlen($employee_address)) {
      AddEmployee($connection, $employee_name, $employee_address);
    }
  }
?>

    <!-- Input form -->
    <form id="form" action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
      <input id='id' type="hidden" name="ID">
      <input id='del' type="hidden" name="del">
      <table border="0">
        <tr>
          <td>NAMA</td>
          <td>ALAMAT</td>
        </tr>
        <tr>
          <td>
            <input id="name" name="NAME" type="text" class="form-control form-control-sm" placeholder="Masukan Nama"
              maxlength="45" size="30">
          </td>
          <td>
            <input id="address" name="ADDRESS" type="text" class="form-control form-control-sm"
              placeholder="Masukan Alamat" maxlength="90" size="60">
          </td>
          <td>
            <button id='submit' type="submit" class="btn btn-block btn-primary btn-sm">Tambah</button>
          </td>
        </tr>
      </table>
    </form>

    <!-- Display table data. -->
    <table class="table mt-5 table-striped">
      <thead class="thead-dark">
        <tr>
          <td>ID</td>
          <td>NAMA</td>
          <td>ALAMAT</td>
          <td>AKSI</td>
        </tr>
      </thead>
      <tbody>
        <?php

$result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>",
       "<td><button type='button' class='btn btn-warning edit' data-id='{$query_data[0]}' data-name='{$query_data[1]}' data-address='{$query_data[2]}' value='{$query_data[0]}'>Ubah</button> | <button type='button' class='btn btn-danger delete' data-id='{$query_data[0]}' value='{$query_data[0]}'>Hapus</button></td>";
  echo "</tr>";
}
?>
      <tbody>
    </table>

    <!-- Clean up. -->
    <?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>
  </div>
  <script>
    $('.edit').click(function () {
      let id = $(this).data('id');
      let name = $(this).data('name');
      let address = $(this).data('address');

      $('#id').val(id);
      $('#name').val(name);
      $('#address').val(address);
      $('#submit').html('Ubah');
      $('#submit').addClass('btn-warning');
    });

    $('.delete').click(function () {
      if (confirm('Apaakah anda yakin, akan menghapus data ini ?')) {
        // Save it!
        let id = $(this).data('id');
        console.log(id);
        $('#id').val(id);
        $('#del').val('delete');
        $.ajax({
          url: "<?PHP echo $_SERVER['SCRIPT_NAME'] ?>",
          type: "post",
          data: {
            ID: id,
            del: "delete",
          },
          success: function (response) {
            location.reload();
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
          }
        });
      } else {
        // Do nothing!
        console.log('Thing was not saved to the database.');
      }
    });
  </script>
</body>

</html>
<?php

/* Add an employee to the table. */
function AddEmployee($connection, $name, $address) {
   $n = mysqli_real_escape_string($connection, $name);
   $a = mysqli_real_escape_string($connection, $address);

   $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

/* Edit an employee to the table. */
function EditEmployee($connection, $name, $address, $id) {
  $i = mysqli_real_escape_string($connection, $id);
  $n = mysqli_real_escape_string($connection, $name);
  $a = mysqli_real_escape_string($connection, $address);

  $query = "UPDATE `employees` SET `ADDRESS` = '$a', `NAME` = '$n' WHERE `employees`.`ID` = '$i';";

  if(!mysqli_query($connection, $query)) echo("<p>Error edditing employee data.</p>");
}

/* Delete an employee to the table. */
function DeleteEmployee($connection, $id) {
  $i = mysqli_real_escape_string($connection, $id);

  $query = "DELETE FROM employees WHERE `employees`.`ID` = '$i';";

  if(!mysqli_query($connection, $query)) echo("<p>Error deleted employee data.</p>");
}

/* Check whether the table exists and, if not, create it. */
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("EMPLOYEES", $connection, $dbName))
  {
     $query = "CREATE TABLE EMPLOYEES (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(45),
         ADDRESS VARCHAR(90)
       )";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;
  return false;
}
?>