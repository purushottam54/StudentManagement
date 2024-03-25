<?php

if (!isset($_GET["id"]) ) {
    header('location:home.php');
}
else
{
    $i = 1;
    $material_type = ["PDF","PPT","Docs","Handwritten Notes","Image"];
    $where = " WHERE material_id = ".$_GET["id"];
    $qry = $conn->query("SELECT * FROM material $where order by material_id asc");
    $row = $qry->fetch_assoc();
}



?>

<div class="container">
  <div class="row">
    <div class="col-12" style="height: 600px; padding-bottom: 20px;"> <!-- Adjust the height and padding-bottom values as needed -->
    <?php
        if ($row['material_type'] == 4) {
            // Display image
            echo '<img src="./assets/uploads/materials/'.$row['material_path'] . '" alt="Image" style="width: 100%; height: 100%;">';
        } else {
            // Display PDF
            echo '<embed src="./assets/uploads/materials/'.$row['material_path'] . '" type="application/pdf" width="100%" height="100%">';
        }
    ?>
    </div>
  </div>
  <div class="row mt-10">
    <div class="col-12 d-flex justify-content-center">
      <button class="btn btn-danger mr-2" onclick="deletePDF()">Delete</button>
      <button class="btn btn-primary mr-2" onclick="editPDF()">Edit</button>
      <a target="_blank" href="./assets/uploads/materials/<?php echo $row['material_path']; ?>" class="btn btn-success">Download</a>
    </div>
  </div>
</div>



<script>
  function deletePDF() {
    // Code to delete PDF
    alert('PDF deleted!');
  }

  function editPDF() {
    // Code to edit PDF
    alert('Editing PDF...');
  }
</script>