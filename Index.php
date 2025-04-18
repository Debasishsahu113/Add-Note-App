<?php
// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Buy Book', 'Please Buy Book From Store', current_timestamp());

//Connect tp the database.
$insert=false;
$update=false;
$delete=false;

$servername="localhost";
$username="root";
$password="";
$database="notes";

mysqli_report(MYSQLI_REPORT_OFF);
//create  a connection object.
 $conn=mysqli_connect($servername,$username,$password,$database);

 
 //Die if the connection was not successful.
 if(!$conn){
    die("Sry we failed to connect:". mysqli_connect_error());
 }
//  else{
//     echo "Connection was successful..!!<br>";
//  }

//Delete The Note,isset returns the boolean value.
if(isset($_GET['delete'])){
  $sno=$_GET['delete'];
  $delete=true;
  $sql="DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
  $result= mysqli_query($conn, $sql);      
  // exit();
  
}

//Update the data 
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['snoEdit'])){
    // echo "yes";
    // UPDATE THE RECORD 
    $sno=$_POST['snoEdit'];
    $title=$_POST['titleEdit'];
    $description=$_POST['descriptionEdit'];
    
     //create Table in the db.
    $sql="UPDATE `notes` SET `title` = '$title', `description`='$description' WHERE `notes`.`sno` = $sno";
    $result= mysqli_query($conn, $sql);      
    // exit();
    if($result){
      $update=true;
    }
    else{
      echo "We Could not update the record successfully...!!";
    }
    
  }
  else{
  //varibles to be inserted into table.
  //Insert The Value
$title=$_POST['title'];
$description=$_POST['description'];

 //create Table in the db.
$sql="INSERT INTO `notes` (`title`, `description`) VALUES ( '$title', '$description')";
$result= mysqli_query($conn, $sql);
if($result){
    // echo "The Value Was Inserted successfully Created...!!<br>";
    $insert=true;
  }
 else{
    echo "The Value  Was Not Added Successfully... Because of this error!! --->".mysqli_error($conn)."<br>";
 }
//  exit();
  }
}
?>

<!-- ////////////////////////////HTML//////////////////// --> 
<!doctype html>
<html lang="en" dir="ltr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap LTR CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
    crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
  
  <title>PHP_Project</title>
  
</head>

<body>

<!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit ThisEdit Node</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- /////////////////MODAL////////////////// popup comming after click edit-->
      <div class="modal-body">
        <form action="/Crud/Index.php" method="post">
         <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="mb-3">
            <label for="title" class="form-label">Note Title</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
          </div>
          <div class="mb-3">
            <label for="desc" class="form-label">Note Discription</label>
            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
          </div>
          <!-- <button type="submit" class="btn btn-primary">Update Node</button> -->
        
    
      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


  <!-- <h1>Hello, World!</h1> -->
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="/Crud/logo.svg" height="30px" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/Crud/Index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>

          <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> -->

          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
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
if($insert){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success...!!</strong> Your notes Has been Submitted...!!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
?>

<?php
if($update){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success...!!</strong> Your notes Has been Updates...!!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
?>

<?php
if($delete){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success...!!</strong> Your notes Has been Deleted...!!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
?>
  <div class="container my-4">
    <h2>Add a Note</h2>
    <form action="/Crud/Index.php" method="post">

      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
      </div>
      <div class="mb-3">
        <label for="desc" class="form-label">Note Discription</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <!-- <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div> -->
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>

  </div>
<!-- Print the table  -->
  <div class="container" my-4>

    <table class="table"id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Discription</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
          $sql="SELECT * FROM `notes`";
          $result= mysqli_query($conn, $sql);
          // echo "The Result is ";
          // echo var_dump($result)."<br>";
           $sno=0;
          while($row=mysqli_fetch_assoc($result)){//it will run until reach to the Null.
            //    echo var_dump($row)."<br>";
            $sno=$sno+1;
            echo "<tr>
             <th scope='row'>".$sno."</th>
             <td>".$row['title']."</td>
             <td>".$row['description']."</td>
             <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> 
             <button class='delete btn btn-sm btn-primary ' id=d".$row['sno'].">Delete</button></td>
        </tr>";
              
        // echo $row['sno']. ".Title". $row['title']."your Description is". $row['description']."<br>";      
      }
      ?>
      </tbody>
    </table>


  </div>
  <hr>
  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

  <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    
  <script>/*for print the data in the same table present in the web.*/
    // let table = new DataTable('#myTable');
    $(document).ready(function(){
      $('#myTable').DataTable();
    });
  </script>
<!-- ////////////////////////////////script for model//////////////// -->
<script>
  edits=document.getElementsByClassName('edit');
  Array.from(edits).forEach((element)=>{
    element.addEventListener("click",(e)=>{
      console.log("edit",);
      tr=e.target.parentNode.parentNode;

    title=tr.getElementsByTagName("td")[0].innerText;
    description=tr.getElementsByTagName("td")[1].innerText;
    console.log(title,description);
    titleEdit.value=title;
    descriptionEdit.value=description;

    snoEdit.value=e.target.id;
    console.log(e.target.id);
    $('#editModal').modal('toggle')
    });
  });


  //for delete button
  deletes=document.getElementsByClassName('delete');
  Array.from(deletes).forEach((element)=>{
    element.addEventListener("click",(e)=>{
      console.log("delete",);
sno=e.target.id.substr(1,);
    if(confirm("Are You Sure You Want To Dele The The the Note")){
      console.log("Yes");
      //create a form and use post request to submit a form
      window.location=`/Crud/Index.php?delete=${sno}`;
    }
    else{
      console.log("No");
    }
    });
  });
</script>
</body>

</html>