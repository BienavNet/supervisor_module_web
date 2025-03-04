const API_BASE_URL = "https://appsalones-production-106a.up.railway.app/api";
// Función para obtener el token de las cookies
function getAuthToken() {
  const token = document.cookie
    .split("; ")
    .find((row) => row.startsWith("access_token="))
    ?.split("=")[1];
  return token || "";
}

// Cargar Google Charts
google.charts.load("current", { packages: ["corechart", "bar", "line"] });
google.charts.setOnLoadCallback(fetchDataAndRenderCharts);

async function fetchDataAndRenderCharts() {
  const token = getAuthToken();
  try {
    const requests = [
      "/reporte/statistics/salon-menos-utilizado",
      "/reporte/statistics/cantidad-dias-asignado",
      "/reporte/statistics/hours-mas-frecuente",
      "/reporte/statistics/docente-mas-comentarios",
    ];

    const responses = await Promise.allSettled(
      requests.map((url) =>
        fetch(`${API_BASE_URL}${url}`, {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        }).then((res) => (res.ok ? res.json() : []))
      )
    );
    console.log("🔍 Responses:", responses);
    responses.forEach((res, index) => {
      if (res.status === "rejected") {
        console.error(`❌ Error en ${requests[index]}:`, res.reason);
      }
    });

    if (!Array.isArray(responses) || responses.length !== requests.length) {
      console.error("❌ Error: Las respuestas no tienen el formato esperado.");
      return;
    }

    const smenosu =
      responses[0]?.status === "fulfilled" ? responses[0].value : [];
    const diasmas =
      responses[1]?.status === "fulfilled" ? responses[1].value : [];
    const hoursmas =
      responses[2]?.status === "fulfilled" ? responses[2].value : [];
    const dqmct =
      responses[3]?.status === "fulfilled" ? responses[3].value : [];

    if (smenosu.length)
      drawBarChart(
        "salonMenosUtilizadoChart",
        smenosu,
        "Salón",
        "Cantidad de usos"
      );
    if (diasmas.length)
      drawLineChart(
        "diasMasAsignadoChart",
        diasmas,
        "Día",
        "Cantidad asignaciones"
      );
    if (hoursmas.length)
      drawPieChart("horasMasFrecuentesChart", hoursmas, "Horas más frecuentes");
    if (dqmct.length)
      drawBarChart(
        "docenteMasComentariosChart",
        dqmct,
        "Docente",
        "Comentarios"
      );
  } catch (error) {
    console.error("❌ Error al obtener los datos:", error);
  }
}

google.charts.setOnLoadCallback(() => {
  setTimeout(fetchDataAndRenderCharts, 100);
});

// Función para gráfico de barras
function drawBarChart(elementId, data, col1, col2) {
  const chartData = new google.visualization.DataTable();
  chartData.addColumn("string", col1);
  chartData.addColumn("number", col2);

  data.forEach((item) => {
    chartData.addRow([
      String(item.numero_salon || item.cedula || item.dia),
      item.cantidad_usos ||
        item.cantidad_comentarios ||
        item.cantidad_repeticiones,
    ]);
  });

  const options = { title: col2, bars: "vertical", height: 300 };
  const chart = new google.visualization.ColumnChart(
    document.getElementById(elementId)
  );
  chart.draw(chartData, options);
}

// Función para gráfico de líneas
function drawLineChart(elementId, data, col1, col2) {
  const chartData = new google.visualization.DataTable();
  chartData.addColumn("string", col1);
  chartData.addColumn("number", col2);

  data.forEach((item) => {
    chartData.addRow([item.dia, item.cantidad_repeticiones]);
  });

  const options = { title: col2, curveType: "function", height: 300 };
  const chart = new google.visualization.LineChart(
    document.getElementById(elementId)
  );
  chart.draw(chartData, options);
}

// Función para gráfico de pastel
function drawPieChart(elementId, data, title) {
  const chartData = new google.visualization.DataTable();
  chartData.addColumn("string", "Hora");
  chartData.addColumn("number", "Repeticiones");

  data.forEach((item) => {
    chartData.addRow([
      `${item.hora_inicio} - ${item.hora_fin}`,
      Number(item.cantidad_repeticiones),
    ]);
  });

  const options = { title, is3D: true, height: 300 };
  const chart = new google.visualization.PieChart(
    document.getElementById(elementId)
  );
  chart.draw(chartData, options);
}
