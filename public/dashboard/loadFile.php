<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
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

<div id="loader" style="display: none; text-align: center; margin-bottom: 20px;">
    <div id="spinner" class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Cargando...</span>
    </div>
    <p id="loaderText">Procesando archivo, por favor espere...</p>
  </div>
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
<form id="uploadForm" method="POST" enctype="multipart/form-data">
<div class="mb-3">
      <label for="fileToUpload" class="form-label">Seleccione el archivo a cargar:</label>
      <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
    </div>

    <div class="mb-3">
    <label for="action" class="form-label">Seleccione el tipo de lista:</label>
  <select name="action" id="action" class="form-select">
   <option value="Seleccione">Seleccione</option>
    <option value="registerClasses">Registrar Clases</option>
    <option value="registerSupervisor">Registrar Supervisores</option>
    <option value="registerDocentes">Registrar Docentes</option>
  </select>
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Cargar Archivo</button>
</form>



<script>
  const useToastify = (messsage, status) => {
  let background;
  if (status === "success") {
    background = "linear-gradient(to right, rgb(46, 184, 11), rgb(62, 135, 6))";
  } else if (status === "error") {
    background = "linear-gradient(to right, #f10909, #5b0b0b)";
  }
  return Toastify({
    text: messsage,
    className: "info",
    style: {
      background: background || "gray",
    },
  }).showToast();
};

document.getElementById('uploadForm').addEventListener('submit', function (e) {
  e.preventDefault();
 
  const formData = new FormData(this);
    const loader = document.getElementById('loader');
    const submitButton = document.querySelector("button[type=submit]");
    const fileInput = document.getElementById("fileToUpload");
    const selectInput = document.getElementById("action");
    const instructions = document.querySelector(".instructions.pt5");

    const file = fileInput.files[0];
    if (!file) {
      useToastify("Por favor seleccione un archivo.", "error");
      fileInput.classList.add("is-invalid");
      return;
    }
    if (file.size > 2 * 1024 * 1024) {
      useToastify("El archivo es demasiado grande (máx. 2MB).", "error");
      fileInput.classList.add("is-invalid");
      return;
    }
    if (!file.name.endsWith(".xlsx")) {
      useToastify("Solo se permiten archivos XLSX.", "error");
      fileInput.classList.add("is-invalid");
      return;
    }
    if (selectInput.value === "Seleccione") {
      useToastify("Seleccione un tipo de lista.", "error");
      selectInput.classList.add("is-invalid");
      return; 
    }

  
    fileInput.classList.remove("is-invalid");
    selectInput.classList.remove("is-invalid");


    loader.style.display = "block";
    submitButton.disabled = true;
    instructions.style.display = "none";

    fetch('../../private/process.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(text => {
      console.log(" text: ", text)
      let errores = [];
      let registrosExitosos = [];
      try {
    const data = JSON.parse(text);

    if (data.successData && data.successData.length > 0) {
      data.successData.forEach(item => {
        registrosExitosos.push(`ID ${item[0]}: ${item[1]}`);
      });
    }

    if (data.data && data.data.length > 0) {
      data.data.forEach(item => {
        const registro = item[0];
        const errorMensaje = item[1];
        errores.push(`ID ${registro[0]}: ${errorMensaje}`);
      });
    }

    if (registrosExitosos.length > 0) {
      useToastify(`${registrosExitosos.length} registros completados exitosamente.`, "success");
      console.log("Registros exitosos:", registrosExitosos);
    }

    if (errores.length > 0) {
      useToastify(`${errores.length} errores encontrados. Verifique los datos.`, "error");
    }
    if (errores.length > 0) {
  errores.forEach(error => {
    useToastify(error, "error"); 
  });

}
  } catch (error) {
    console.error("Error al parsear JSON:", error);
    useToastify("Respuesta del servidor inválida.", "error");
  }
    })
    .catch(error => {
      useToastify("Error al conectar con el servidor.", "error");
    })
    .finally(() => {
      loader.style.display = "none";
      instructions.style.display = "block";
      submitButton.disabled = false;
    });
})
  </script>
</body>

</html>