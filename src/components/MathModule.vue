<template>
  <div>
    <ul class="nav nav-tabs my-3">
      <li class="nav-item">
        <a
          @click.prevent="activeTab = 'inputs'"
          class="nav-link"
          :class="{ active: activeTab == 'inputs'}"
          href="#"
        >Входные данные</a>
      </li>
      <li class="nav-item">
        <a
          @click.prevent="activeTab = 'results'"
          class="nav-link"
          :class="{ active: activeTab == 'results', disabled: !calculated }"
          href="#"
        >Выходные данные</a>
      </li>
      <li class="nav-item">
        <a 
          class="nav-link" 
          href="#"
          @click.prevent="activeTab = 'chart'"
          :class="{ active: activeTab == 'chart', disabled: !calculated }"
        >График</a>
      </li>
      <li class="nav-item">
        <a 
          class="nav-link" 
          href="#"
          @click.prevent="activeTab = 'optimisation'"
          :class="{ active: activeTab == 'optimisation', disabled: !calculated }"
        >Оптимизация</a>
      </li>
    </ul>

    <!-- Входные параметры -->
    <form @submit.prevent="calculate" v-if="activeTab == 'inputs'">     
      <table class="table">
        <tbody>
          <tr>
            <td>
              <b>Параметры станка</b>
            </td>
            <td colspan="3">
              <select class="form-control" v-model="currentMachine">
                <option value="">Выберите станок</option>
                <option v-for="(item, key) in machines" :key="key" :value="key">{{ key }}</option>
              </select>
            </td>
          </tr>
          <tr v-for="(item, key) in machineParameters" :key="key">
            <td>{{ item.text }}</td>
            <td v-html="item.alias"></td>
            <td>
              <input type="text" class="form-control form-control-sm" v-model="item.value">
            </td>
            <td v-html="item.units"></td>
          </tr>

          <tr>
            <td>
              <b>Параметры материала</b>
            </td>
            <td colspan="3">
              <select class="form-control" v-model="currentMaterial">
                <option value="">Выберите материал</option>
                <option v-for="(item, key) in materials" :key="key" :value="key">{{ key }}</option>
              </select>
            </td>
          </tr>
          <tr v-for="(item, key) in materialParameters" :key="key">
            <td>{{ item.text }}</td>
            <td v-html="item.alias"></td>
            <td>
              <input type="text" class="form-control form-control-sm" v-model="item.value">
            </td>
            <td v-html="item.units"></td>
          </tr>

          <tr>
            <td>
              <b>Параметры электролита</b>
            </td>
            <td colspan="3">
              <select class="form-control" v-model="currentElectrolyte">
                <option value="">Выберите электролит</option>
                <option v-for="(item, key) in electrolytes" :key="key" :value="key">{{ key }}</option>
              </select>
            </td>
          </tr>
          <tr v-for="(item, key) in electrolyteParameters" :key="key">
            <td>{{ item.text }}</td>
            <td v-html="item.alias"></td>
            <td>
              <input type="text" class="form-control form-control-sm" v-model="item.value">
            </td>
            <td v-html="item.units"></td>
          </tr>

          <tr>
            <td>
              <b>Параметры математической модели</b>
            </td>
            <td colspan="3">
              <button 
                class="btn btn-primary btn-block" 
                @click.prevent="loadStandardMathParameters"
              >Загрузить стандартные</button>
            </td>
          </tr>
          <tr v-for="(item, key) in mathParameters" :key="key">
            <td>{{ item.text }}</td>
            <td v-html="item.alias"></td>
            <td>
              <input type="text" class="form-control form-control-sm" v-model="item.value">
            </td>
            <td v-html="item.units"></td>
          </tr>

          <tr>
            <td>
              <b>Варьируемые параметры</b>
            </td>
            <td colspan="3">
              <button 
                class="btn btn-primary btn-block" 
                @click.prevent="loadStandardVariableParameters"
              >Загрузить стандартные</button>
            </td>
          </tr>
          <tr v-for="(item, key) in variableParameters" :key="key">
            <td>{{ item.text }}</td>
            <td v-html="item.alias"></td>
            <td>
              <input type="text" class="form-control form-control-sm" v-model="item.value">
            </td>
            <td v-html="item.units"></td>
          </tr>
        </tbody>
      </table>

      <div>
        <button 
          class="btn btn-success btn-block mb-3"
          :disabled="!parametersChecked"
        >Рассчитать</button>
      </div>
    </form>

    <!-- Результаты расчёта -->
    <div class="results text-center" v-if="activeTab == 'results'">
      <h3>Результаты расчёта</h3>
      <table class="table">
        <thead>
          <th>Номер</th>
          <th>Время от начала, мин</th>
          <th>Межэлектродный промежуток, мкм</th>
          <th>Амплитудная сила тока в импульсе, А</th>
          <th>Координата торца электрод-инструмента, мкм</th>
          <th>Практический удельный съём, г/(А*ч)</th>
          <th>Амплитудная плотность тока, А/см<sup>2</sup></th>
          <th>Удельная электропроводность среды, (Ом*м)<sup>-1</sup></th>
        </thead>
        <tbody>
          <tr v-for="(item, index) in results" :key="index">
            <td>{{ index }}</td>
            <td>{{ item.t }}</td>
            <td>{{ item.s }}</td>
            <td>{{ item.I }}</td>
            <td>{{ item.Z }}</td>
            <td>{{ item.G }}</td>
            <td>{{ item.j }}</td>
            <td>{{ item.x }}</td>
          </tr>
        </tbody>
      </table>
      <div>
        <button 
          class="btn btn-success btn-block"
          @click="activeTab = 'chart'"
        >Показать на графике</button>
        <button 
          class="btn btn-success btn-block"
          @click="activeTab = 'optimisation'"
        >Оптимизировать</button>
      </div>
    </div>

    <!-- График -->
    <div class="chart" v-if="activeTab == 'chart'">
      <app-charts :results="results"></app-charts>
    </div>

    <!-- Оптимизация -->
    <app-optimisation v-if="activeTab == 'optimisation'">
    </app-optimisation>
  </div>
</template>

<script>
import axios from "axios";
import AppOptimisation from "./Oprimisation";
import AppCharts from "./Charts";

export default {
  components: {
    AppOptimisation,
    AppCharts
  },
  
  data() {
    return {
      activeTab: "inputs",
      machineParameters: {
        A: {
          value: null,
          text: "Амплитуда колебаний электрод-инструмента",
          units: 'мкм',
        },
        Pel: {
          value: null,
          text: "Давление электролита на входе в межэлектродный промежуток",
          units: 'кПа',
          alias: 'P<sub>эл</sub>'
        },
        S: {
          value: null,
          text: "Площадь поверхности обработки",
          units: 'см<sup>2</sup>',
        },
        f: {
          value: null,
          text: "Частота подачи импульсов тока и колебаний электрод-инструмента",
          units: 'Гц',
        },
        timp: {
          value: null,
          text: "Длительность импульсов тока",
          units: 'мс',
          alias: 't<sub>имп</sub>'
        },
        phase: {
          value: null,
          text: "Фаза подачи импульсов",
          units: '%',
          alias: 'Ψ'
        },
        s0: {
          value: null,
          text: "Начальный межэлектродный промежуток",
          units: 'мкм',
          alias: 's<sub>0</sub>'
        },
      },
      materialParameters: {
        G0: {
          value: null,
          text: "Максимальное значение практического удельного съёма",
          units: 'г/(А*ч)',
          alias: 'G<sub>0</sub>'
        },
        i1: {
          value: null,
          text: "Эмпирический коэффициент",
          units: 'А/см<sup>2</sup>',
        },
        i2: {
          value: null,
          text: "Эмпирический коэффициент",
          units: 'А/см<sup>2</sup>',
        },
        l1: {
          value: null,
          text: "Эмпирический коэффициент",
          units: 'мкм',
        },
        l2: {
          value: null,
          text: "Эмпирический коэффициент",
          units: 'мкм',
        },
        rho: {
          value: null,
          text: "Плотность материала заготовки",
          units: 'г/см<sup>2</sup>',
          alias: 'ρ'
        },
      },
      electrolyteParameters: {
        x0: {
          value: null,
          text: "Удельная электропроводность чистого электролита",
          units: '(Ом*м)<sup>-1</sup>',
          alias: 'χ<sub>0</sub>'
        },
        C: {
          value: null,
          text: "Концентрация",
          units: '%',
        },
      },
      mathParameters: {
        eps: {
          value: null,
          text: "Точность вычисления",
          units: '%',
          alias: 'ε'
        },
        dt: {
          value: null,
          text: "Шаг по времени",
          units: "с",
          alias: 'Δt'
        },
      },
      variableParameters: {
        U0: {
          value: null,
          text: "Заданное напряжение в момент наибольшего сближения электродов",
          units: "В",
          alias: 'U<sub>0</sub>'
        },
        Vn: {
          value: null,
          text: "Скорость подачи электрода-инструмента",
          units: "мкм/мин",
          alias: 'V<sub>n</sub>'
        },
      },
      machines: {},
      electrolytes: {},
      materials: {},
      currentMachine: "",
      currentElectrolyte: "",
      currentMaterial: "",
      results: [],
      inputParameters: {},
      standardParameters: {},
      calculated: false
    };
  },

  computed: {
    parametersChecked() {
      for (let key in this.machineParameters) {
        let item = this.machineParameters[key].value;
        if (item === null || item === "")
          return false;
        
        item = +item;

        if (isNaN(item))
          return false;
      }

      for (let key in this.materialParameters) {
        let item = this.materialParameters[key].value;
        if (item === null || item === "")
          return false;
        
        item = +item;

        if (isNaN(item))
          return false;
      }

      for (let key in this.electrolyteParameters) {
        let item = this.electrolyteParameters[key].value;
        if (item === null || item === "")
          return false;
        
        item = +item;

        if (isNaN(item))
          return false;
      }

      for (let key in this.mathParameters) {
        let item = this.mathParameters[key].value;
        if (item === null || item === "")
          return false;
        
        item = +item;

        if (isNaN(item))
          return false;
      }

      for (let key in this.variableParameters) {
        let item = this.variableParameters[key].value;
        if (item === null || item === "")
          return false;
        
        item = +item;

        if (isNaN(item))
          return false;
      }

      return true;
    },
  },

  methods: {
    getInputParameters() {
      let query = JSON.stringify({
        query_type: "get_input_parameters"
      });

      axios.post("/backend/", `query=${query}`).then(res => {
        this.$set(this, 'inputParameters', res.data);
        for (let i in this.inputParameters.machines) {
          this.$set(this.machines, i, this.inputParameters.machines[i]);
        }
        for (let i in this.inputParameters.electrolytes) {
          this.$set(this.electrolytes, i, this.inputParameters.electrolytes[i]);
        }
        for (let i in this.inputParameters.materials) {
          this.$set(this.materials, i, this.inputParameters.materials[i]);
        }
      });
    },

    getStandardParameters() {
      axios.get("/backend/json/standardParameters.json")
        .then(res => {
          this.$set(this, 'standardParameters', res.data);
        })
    },

    

    addAliases() {
      for (let i in this.machineParameters) {
        let item = this.machineParameters[i];
        if (item.alias) continue;
        item.alias = i;
      }
      for (let i in this.electrolyteParameters) {
        let item = this.electrolyteParameters[i];
        if (item.alias) continue;
        item.alias = i;
      }
      for (let i in this.materialParameters) {
        let item = this.materialParameters[i];
        if (item.alias) continue;
        item.alias = i;
      }
    },

    loadStandardMathParameters() {
      for (let key in this.standardParameters.mathParameters) {
        this.mathParameters[key].value = this.standardParameters.mathParameters[key];
      }
    },

    loadStandardVariableParameters() {
      for (let key in this.standardParameters.variableParameters) {
        this.variableParameters[key].value = this.standardParameters.variableParameters[key];
      }
    },

    calculate() {
      setTimeout(() => {
        this.loadResults();
        this.calculated = true;
      }, 400)
    },

    loadResults() {
      axios.get("/backend/json/results.json")
        .then(res => {
          console.log(res.data);
          this.$set(this, 'results', res.data);
          this.activeTab = "results";
        })
    },

  },

  watch: {
    currentMachine(val) {
      if (!val) {
        for (let key in this.machineParameters) {
          this.machineParameters[key].value = null;
        }
        return;
      }
      
      let parameters = this.inputParameters.machines[val];
      for (let key in parameters) {
        this.machineParameters[key].value = parameters[key];
      }
    },
    currentMaterial(val) {
      if (!val) {
        for (let key in this.materialParameters) {
          this.materialParameters[key].value = null;
        }
        return;
      }

      let parameters = this.inputParameters.materials[val];
      for (let key in parameters) {
        this.materialParameters[key].value = parameters[key];
      }
    },
    currentElectrolyte(val) {
      if (!val) {
        for (let key in this.electrolyteParameters) {
          this.electrolyteParameters[key].value = null;
        }
        return;
      }

      let parameters = this.inputParameters.electrolytes[val];
      for (let key in parameters) {
        this.electrolyteParameters[key].value = parameters[key];
      }
    },
  },

  created() {
    this.addAliases();
    this.getInputParameters();
    this.getStandardParameters();
  }
};

</script>

<style lang="scss" scoped>
  td {
    padding: 2px;
  }
</style>
