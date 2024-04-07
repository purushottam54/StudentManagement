<?php

if (!isset($_GET["id"]) ) {
    header('location:home.php');
}
else
{
    $i = 1;
    $material_type = ["PDF","PPT","Docs","Handwritten Notes","Image"];
    $where = " WHERE scholarship_id = ".$_GET["id"];
    $qry = $conn->query("SELECT * FROM scholarship $where order by scholarship_id asc");
    $row = $qry->fetch_assoc();
}



?>

<div class="container">
  <div class="row">
    <div class="col-12" style="height: 600px; padding-bottom: 20px;"> <!-- Adjust the height and padding-bottom values as needed -->
    <?php
            echo '<embed src="./assets/uploads/scholarship/'.$row['scholarship_document'] . '" type="application/pdf" width="100%" height="100%">';
    ?>
    </div>
  </div>
  <div class="row mt-10">
    <div class="col-12 d-flex justify-content-center">
      <a target="_blank" href="./assets/uploads/scholarship/<?php echo $row['scholarship_document']; ?>" class="btn btn-success">Download</a>
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