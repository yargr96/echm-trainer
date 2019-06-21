<template>
  <div>
    <chart-one :chartdata="chartdata" :options="options"></chart-one>
  </div>
</template>


<script>
import ChartOne from "./ChartOne";

export default {
  components: {
    ChartOne
  },
  props: ['results'],
  data() {
    return {
      
    };
  },
  computed: {
    chartdata() {
      let labels = [];
      let data = [];
      this.results.forEach(val => {
        labels.push(val.j);
        data.push(val.G);
      })
      console.log(labels, data)
      return {
        // labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050],
        labels: labels,
        datasets: [
          {
            data: data,
            label: "",
            borderColor: "#3e95cd",
            fill: false
          },
        ]
      }
    },
    options() {
      return {
        title: {
          display: true,
          text: "Зависимость практического удельного съема от амплитудной плотности тока"
        },
        scales: {
          yAxes: [{ 
            scaleLabel: {
              display: true,
              labelString: "Практический удельный съём г/(А*ч)"
            }
          }],
          xAxes: [{ 
            scaleLabel: {
              display: true,
              labelString: "Амплитудная плотность тока j, А/см^2"
            }
          }]
        }
      }
    }
  }
};
</script>
