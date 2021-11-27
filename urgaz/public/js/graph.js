new Chart(document.getElementById("line-chart"), {
  type: "line",
  data: {
    labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 2000, 2050],
    datasets: [
      {
        data: [2282, 5350, 4411, 5502, 3635, 1809, 2947, 2402, 4700, 5267],
        label: "First line",
        borderColor: "#1e2a78",
        fill: true,
        backgroundColor: "rgba(48,227,202,0.05)"
      },
      {
        data: [2168, 3170, 1178, 4190, 3203, 1276, 408, 1947, 2675, 2734],
        label: "Second line",
        borderColor: "#ff304f",
        fill: true,
        backgroundColor: "#f9ff21"
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: "Your Graph title"
    }
  }
});
