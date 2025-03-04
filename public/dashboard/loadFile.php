<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      padding: 20px;
    }
    .instructions {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
    }

    @media (max-width: 1080px) {
      .pt5{
        margin-top:50px;
    }
    }
  </style>
</head>
<body>

<div class="instructions pt5">
    <h4>Instrucciones para cargar el archivo</h4>
    <ol>
      <li>Seleccione el tipo de lista que desea registrar.</li>
      <li>Suba el archivo correspondiente (CSV).</li>
      <li>Haga clic en "Cargar Archivo" y listo.</li>
    </ol>

    <div class="alert alert-info" role="alert">
      <p class="mb-0"> Para asegurarse de que el archivo cargado tenga el formato correcto, descargue los ejemplos de los archivos Excel:</p>
      <ul class="list-unstyled mt-3">
        <li><a href="../../example.xlsx" download>Formato Docentes y Supervisores</a></li>
        <li><a href="../../upload.xlsx" download>Formato Clases</a></li>
      </ul>
    </div>
</div>
<form action="../../private/process.php" method="POST" enctype="multipart/form-data">
<div class="mb-3">
      <label for="fileToUpload" class="form-label">Seleccione el archivo a cargar:</label>
      <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
    </div>

    <div class="mb-3">
    <label for="action" class="form-label">Seleccione el tipo de lista:</label>
  <select name="action" id="action" class="form-select">
    <option value="registerClasses">Registrar Clases</option>
    <option value="registerSupervisor">Registrar Supervisores</option>
    <option value="registerDocentes">Registrar Docentes</option>
  </select>
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Cargar Archivo</button>
</form>

</body>
</html>