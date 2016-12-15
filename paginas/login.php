<?php
extract($_GET);

echo isset($msg)?$msg:"no hay mensaje";
echo "jaosdijaojsod";

?>
<form role="form" action="checkpass.php" method="post">
  <div class="form-group">
    <label for="name">¿Tú quien eres?</label>
    <input name="name" type="text" class="form-control" id="name" placeholder="Desembucha...">
  </div>
  <div class="form-group">
    <label for="pass">Santo y seña</label>
    <input name="pass" type="password" class="form-control" id="pass" placeholder="Pass plz">
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox"> Check me out!
    </label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>