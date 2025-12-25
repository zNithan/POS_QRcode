
// Format and organize the code for better readability
var colors = ["#1c84ee", "#7f56da", "#ff6c2f", "#f9b931"];

// Simple Pie Chart
var options = {
    chart: { height: 330, type: "pie" },
    series: [44, 55, 41, 17],
    labels: ["โอนเงิน", "เงินสด", "พร้อมเพย์", "บัตรเครดิต"],
    colors: colors,
    legend: { show: true, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: false, fontSize: "14px", offsetX: 0, offsetY: 7 },
    responsive: [{ breakpoint: 600, options: { chart: { height: 240 }, legend: { show: false } } }]
};
var chart = new ApexCharts(document.querySelector("#simple_pie"), options);
chart.render();