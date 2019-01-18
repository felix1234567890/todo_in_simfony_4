const newPie = document.querySelector("#pie3");
const newPieChart = d3.select(newPie).append("svg");
const newWidth = 600;
const newHeight = 600;
const newRadius = Math.min(width, height) / 2;
const g = newPieChart
  .attr("width", newWidth)
  .attr("height", newHeight)
  .append("g")
  .attr("transform", "translate(" + newWidth / 2 + "," + newHeight / 2 + ")");

const Color = d3.scaleOrdinal([
  //"#98abc5",
  // "#8a89a6",
  // "#7b6888",
  // "#6b486b"
  "#a05d56",
  "#d0743c",
  "#ff8c00"
]);
newData = [
  { tvar: "Bjelančevine", udio: 30 },
  { tvar: "Masti", udio: 30 },
  { tvar: "Šećeri", udio: 40 }
];
var Piepie = d3
  .pie()
  .sort(null)
  .value(function(d) {
    return d.udio;
  });

var Path = d3
  .arc()
  .outerRadius(radius - 10)
  .innerRadius(0);

var label = d3
  .arc()
  .outerRadius(radius - 70)
  .innerRadius(radius - 70);

var arc = g
  .selectAll(".arc")
  .data(Piepie(newData))
  .enter()
  .append("g")
  .attr("class", "arc");

arc
  .append("path")
  .attr("d", Path)
  .attr("fill", function(d, i) {
    return Color(i);
  });

arc
  .append("text")
  .attr("font-size", "18px")
  .attr("transform", function(d) {
    return "translate(" + label.centroid(d) + ")";
  })
  .attr("dy", "0.35em")
  .text(function(d) {
    return d.data.tvar;
  });
