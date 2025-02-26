<!DOCTYPE html>
<html>
<body>

<form action="../../private/process.php" method="POST" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <select name="action" id="action">
    <option value="registerClasses">Registrar Clases</option>
    <option value="registerSupervisor">Registrar Supervisores</option>
    <option value="registerDocentes">Registrar Docentes</option>
  </select>
  <input type="submit" value="Cargar Archivo" name="submit">
</form>

</body>
</html>