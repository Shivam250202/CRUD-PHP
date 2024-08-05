<?php
$insert = false;
$update = false;
$updateError = false;
$delete = false;
$deleteError = false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "Crud";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// If connection was not successful
if (!$conn) {
    die("Sorry, we failed to connect: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['SNoEdit'])) {
        // Update the Record
        $SNo = mysqli_real_escape_string($conn, $_POST["SNoEdit"]);
        $Title = mysqli_real_escape_string($conn, $_POST["TitleEdit"]);
        $Description = mysqli_real_escape_string($conn, $_POST["DescriptionEdit"]);

        // SQL query to be executed
        $sql = "UPDATE `crud` SET `Title` = '$Title' , `Description` = '$Description' WHERE `crud`.`SNo` = $SNo";
        $result = mysqli_query($conn, $sql);

        // Debugging output
        if ($result) {
            $update = true;
        } else {
            $updateError = true;
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        $Title = mysqli_real_escape_string($conn, $_POST["Title"]);
        $Description = mysqli_real_escape_string($conn, $_POST["Description"]);

        // SQL query to be executed
        $sql = "INSERT INTO `crud` (`Title`, `Description`) VALUES ('$Title', '$Description')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $insert = true;
        } else {
            echo "The record was not inserted successfully because of this error ----> " . mysqli_error($conn);
        }
    }
}

if (isset($_GET['delete'])) {
    $SNo = $_GET['delete'];

    // SQL query to be executed
    $sql = "DELETE FROM `crud` WHERE `crud`.`SNo` = $SNo";
    $result = mysqli_query($conn, $sql);

    // Debugging output
    if ($result) {
        $delete = true;
    } else {
        $deleteError = true;
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.min.css">

    <!-- DataTables JS CDN -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
</head>

<body>
    <!-- EDIT modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditModal">
    Edit Modal
    </button> -->

    <?php
    if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if ($updateError) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Oops Error!</strong> You should check in on some of those fields below.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if ($deleteError) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Oops Error!</strong> There was an error deleting the note.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    ?>

    <!-- EDIT Modal -->
    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="EditModalLabel"> Edit this Note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/CRUD PHP/index.php" method="post">
                        <input type="hidden" name="SNoEdit" id="SNoEdit">
                        <div class="mb-3">
                            <label for="Title" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="TitleEdit" name="TitleEdit">
                        </div>
                        <div class="mb-3">
                            <label for="Description" class="form-label">Note Description</label>
                            <textarea class="form-control" id="DescriptionEdit" name="DescriptionEdit" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="/CRUD PHP/PHP.png" height="40px" alt="" srcset=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been inserted successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    ?>

    <div class="container my-5">
        <h2>Add a Note</h2>
        <form action="/CRUD PHP/index.php" method="post">
            <div class="mb-3">
                <label for="Title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="Title" name="Title">
            </div>
            <div class="mb-3">
                <label for="Description" class="form-label">Note Description</label>
                <textarea class="form-control" id="Description" name="Description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>
    <div class="container my-4">
        <table class="table" id="myTable">
            <hr>
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `crud`";
                $result = mysqli_query($conn, $sql);
                $SNo = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $SNo++;
                    echo "<tr>
                    <th scope='row'>" . $SNo . "</th>
                    <td>" . htmlspecialchars($row['Title']) . "</td>
                    <td>" . htmlspecialchars($row['Description']) . "</td>
                    <td> 
                        <button class='Edit btn btn-sm btn-primary' id=" . $row['SNo'] . " >Edit</button>  
                        <button class='Delete btn btn-sm btn-danger' id=d" . $row['SNo'] . " >Delete</button>
                    </td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        document.addEventListener("DOMContentLoaded", () => {
            const edits = document.getElementsByClassName('Edit');
            Array.from(edits).forEach((element) => {
                element.addEventListener("click", (e) => {
                    console.log("Edit", );
                    tr = e.target.parentNode.parentNode;
                    Title = tr.getElementsByTagName("td")[0].innerText;
                    Description = tr.getElementsByTagName("td")[1].innerText;
                    console.log(Title, Description);
                    TitleEdit.value = Title;
                    DescriptionEdit.value = Description;
                    SNoEdit.value = e.target.id;
                    console.log(e.target.id);
                    $('#EditModal').modal('toggle');
                });
            });

            const deletes = document.getElementsByClassName('Delete');
            Array.from(deletes).forEach((element) => {
                element.addEventListener("click", (e) => {
                    const SNo = e.target.id.substr(1);
                    if (confirm("Are you sure you want to delete this note?")) {
                        window.location = `/CRUD PHP/index.php?delete=${SNo}`;
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>