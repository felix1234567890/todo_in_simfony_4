const margin = 30;
const svgWidth = 600;
const svgHeight = 600;
const data = [100, 120, 130, 410, 150];
const barWidth = svgWidth / data.length;
const barPadding = 5;

let graph = d3
  .select("svg")
  .attr("width", svgWidth)
  .attr("height", svgHeight)
  .attr("class", "bar-chart");

graph
  .selectAll("rect")
  .data(data)
  .enter()
  .append("rect")
  .attr("class", "bar")
  .attr("y", function(d) {
    return svgHeight - d;
  })
  .attr("height", function(d) {
    return d;
  })
  .attr("width", barWidth - barPadding)
  .attr("transform", function(d, i) {
    var xCoordinate = barWidth * i;
    return "translate(" + xCoordinate + ")";
  });

const pieData = [
  { naziv: "Prvi dio", udio: 50 },
  { naziv: "Drugi dio", udio: 20 },
  { naziv: "Treći dio", udio: 30 }
];

const pieWidth = 600;
const pieHeight = 600;
const radius = Math.min(pieWidth, pieHeight) / 2;
const color = d3.scaleOrdinal(["#4daf4a", "#377eb8", "#ff7f00"]);

const pie = document.querySelector("#pie");
let pieChart = d3
  .select(pie)
  .append("svg")
  .attr("width", pieWidth)
  .attr("height", pieHeight)
  .style("background", "pink")
  .append("g")
  .attr("transform", "translate(" + pieWidth / 2 + "," + pieHeight / 2 + ")");
const d3Piedata = d3
  .pie()
  .sort(null)
  .value(function(d) {
    return d.udio;
  })(pieData);

const segments = d3
  .arc()
  .innerRadius(0)
  .outerRadius(radius)
  .padAngle(0.15)
  .padRadius(60);
// const labelArc = d3
//   .arc()
//   .outerRadius(radius - 40)
//   .innerRadius(radius - 40);
pieChart
  .selectAll(".arc")
  .data(d3Piedata)
  .enter()
  .append("path")
  .attr("d", segments)
  .attr("fill", function(d, i) {
    return color(i);
  });

var newMargin = { top: 20, right: 10, bottom: 30, left: 25 },
  width = 660 - newMargin.left - newMargin.right,
  height = 500 - newMargin.top - newMargin.bottom;

// set the ranges
var x = d3
  .scaleBand()
  .range([0, width])
  .padding(0.1);
var y = d3.scaleLinear().range([height, 0]);

// append the svg object to the body of the page
// append a 'group' element to 'svg'
// moves the 'group' element to the top left margin
const newBar = document.querySelector("#pie2");
var svg = d3
  .select(newBar)
  .append("svg")
  .attr("width", width + newMargin.left + newMargin.right)
  .attr("height", height + newMargin.top + newMargin.bottom)
  .append("g")
  .attr("transform", "translate(" + newMargin.left + "," + newMargin.top + ")");

// get the data
d3.csv("index.csv", function(error, data) {
  if (error) throw error;

  // Scale the range of the data in the domains
  x.domain(
    data.map(function(d) {
      return d.ime;
    })
  );
  y.domain([
    0,
    d3.max(data, function(d) {
      return d.visina;
    })
  ]);

  // append the rectangles for the bar chart
  svg
    .selectAll(".bar")
    .data(data)
    .enter()
    .append("rect")
    .attr("fill", "#21c677")
    .attr("x", function(d) {
      return x(d.ime);
    })
    .attr("width", x.bandwidth())
    .attr("y", function(d) {
      return y(d.visina);
    })
    .attr("height", function(d) {
      return height - y(d.visina);
    });

  // add the x Axis
  svg
    .append("g")

    .attr("transform", "translate(0," + height + ")")
    .call(d3.axisBottom(x));

  // add the y Axis
  svg.append("g").call(d3.axisLeft(y));
});
