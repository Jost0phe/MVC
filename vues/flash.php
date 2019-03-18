<div class="alert alert-<?=$_SESSION['msgStyle'];?> alert-dismisible fade show" role="alert">
    <?=$_SESSION['msgTxt'];?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<script>
    $('.alert').alert();
</script>