// Chart 1: Product Trends by Month
var options = {
    chart: {
        toolbar: { show: false },
        height: 320,
        type: "line",
        zoom: { enabled: false }
    },
    dataLabels: { enabled: false },
    colors: ["#7f56da"],
    stroke: { width: [4], curve: "straight" },
    series: [{ name: "Desktops", data: [30, 41, 35, 51, 49, 62, 69, 91, 126] }],
    title: { text: "ยอดขาย", align: "center" },
    grid: {
        row: { colors: ["transparent", "transparent"], opacity: 0.2 },
        borderColor: "#f1f3fa"
    },
    labels: series.monthDataSeries1.dates,
    xaxis: { categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep"] },
    responsive: [{ breakpoint: 600, options: { chart: { toolbar: { show: false } }, legend: { show: false } } }]
};
new ApexCharts(document.querySelector("#chart_line"), options).render();