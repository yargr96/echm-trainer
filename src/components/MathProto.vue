<template>
  <div>
    <table>
      <thead>
        <th>i</th>
        <th>t</th>
        <th>Z</th>
        <th>j</th>
        <th>I</th>
        <th>G</th>
        <th>x</th>
      </thead>
      <tbody>
        <tr v-for="(item, index) in outputs" :key="index">
          <td>{{ item.i }}</td>
          <td>{{ item.t }}</td>
          <td>{{ item.Z }}</td>
          <td>{{ item.j }}</td>
          <td>{{ item.I }}</td>
          <td>{{ item.G }}</td>
          <td>{{ item.x }}</td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-success" @click="calculate">Calculate</button>
    <table class="table">
      <tbody>
        <tr v-for="(item, key) in inputs" :key="key">
          <td>{{ item.text }}</td>
          <td>
            {{ key }}
          </td>
          <td>
            <input v-model="item.value" type="text" class="form-control form-control-sm">
          </td>
          <td>{{ item.unit }}</td>
        </tr>
      </tbody>
    </table>
    {{ siInputs }}
  </div>
</template>

<script>
export default {
  data() {
    return {
      inputs: {
        U0: {
          text: "Заданное напряжение в момент наибольшего сближения электродов",
          value: 9,
          unit: 'В'
        },
        timp: {
          text: "Длительность импульса тока",
          value: 1.2,
          unit: 'мс'
        },
        Vn: {
          text: "Скорость подачи электрод-инструмента",
          value: 60,
          unit: 'мкм/мин'
        },
        f: {
          text: "Частота подачи импульсов тока и колебаний электрод-инструмента",
          value: 47,
          unit: 'Гц'
        },
        A: {
          text: "Амплитуда колебаний электрод-инструмента",
          value: 150,
          unit: 'мкм'
        },
        Pel: {
          text: "Давление электролита на входе в межэлектродный промежуток",
          value: 150,
          unit: 'кПа'
        },
        Phase: {
          text: "Фаза подачи импульсов",
          value: 0.5,
          unit: '%'
        },
        x0: {
          text: "Удельная электропроводность чистого электролита",
          value: 8.48,
          unit: 'См/мм'
        },
        G0: {
          text: "Максимальное значение практического удельного съёма",
          value: 0.64,
          unit: 'г/(А*ч)'
        },
        i1: {
          text: "Эмпрический коэффициент",
          value: 15.3,
          unit: 'А/(см^2)'
        },
        i2: {
          text: "Эмпрический коэффициент",
          value: -3.2,
          unit: 'А/(см^2)'
        },
        l1: {
          text: "Эмпрический коэффициент",
          value: 0,
          unit: 'мкм'
        },
        l2: {
          text: "Эмпрический коэффициент",
          value: 44.9,
          unit: 'мкм'
        },
        rho: {
          text: "Плотность материала",
          value: 7.9,
          unit: 'г/(см^3)'
        },
        S: {
          text: "Площадь заготовки",
          value: 2,
          unit: 'см^2'
        },
        Eps: {
          text: "Точность вычисления",
          value: 10,
          unit: '%'
        },
        dt: {
          text: "Шаг по времени",
          value: 1,
          unit: 'мин'
        },
        s0: {
          text: "Начальный межэлектродный промежуток",
          value: 300,
          unit: 'мкм'
        },
      },
      siOutputs: [],
      // Fi: -1091.18
      Fi: 8.9945
    }
  },
  computed: {
    siInputs() {
      let inputs = {
        timp: this.inputs.timp.value * 0.001,
        Vn: this.inputs.Vn.value * 1.66667e-8,
        A: this.inputs.A.value * 1e-6,
        Pel: this.inputs.Pel.value * 1000,
        x0: this.inputs.x0.value * 1000,
        G0: this.inputs.G0.value * 2.77777778e-7,
        i1: this.inputs.i1.value * 10000,
        i2: this.inputs.i2.value * 10000,
        l1: this.inputs.l1.value * 1e-6,
        l2: this.inputs.l2.value * 1e-6,
        rho: this.inputs.rho.value * 1000,
        S: this.inputs.S.value * 0.0001,
        dt: this.inputs.dt.value * 60,
        s0: this.inputs.s0.value * 1e-6
      };

      for (let key in this.inputs) {
        if (inputs[key] !== undefined)
          continue;
        inputs[key] = this.inputs[key].value;
      }

      return inputs;
    },
    outputs() {
      const list = [];
      for (let i = 0; i < this.siOutputs.length; i++) {
        let siRow = this.siOutputs[i];
        let row = {
          i: siRow.i,
          s: siRow.s * 1e6, // мкм
          Z: siRow.Z * 1e6, // мкм
          G: siRow.G / 2.77777778e-6, // г/(А*ч)
          I: siRow.I, // А/(см^2)
          x: siRow.x / 1000, // 1/(Ом*м)б
          j: siRow.j * 0.0002,
          t: siRow.t / 60
        }

        list.push(row);
      }

      return list;
    }
  },
  methods: {
    calculate() {
      let i = 0;
      const so = this.siOutputs;
      const si = this.siInputs;

      let row = {
        i: i,
        s: si.s0,
        t: 0,
        Z: -si.s0,
      };
      row.j = getJ({
        U0: si.U0,
        Fi: this.Fi,
        x0: si.x0,
        si: si.s0,
        l1: si.l1,
        l2: si.l2,
      });
      row.I = row.j / 10000;
      row.G = getG({
        G0: si.G0,
        ji: row.j,
        i1: si.i1,
        i2: si.i2
      });
      row.x = si.x0 * (row.s + si.l1) / (row.s + si.l2);
      so.push(row);

      do {
        i++;
        let s = so[i - 1].s + si.dt 
                * ( (so[i - 1].G * so[i-1].x * (si.U0 - this.Fi) * si.timp * si.f) 
                / (si.rho * so[i - 1].s - si.Vn) );
        let j = getJ({
          U0: si.U0,
          Fi: this.Fi,
          x0: si.x0,
          si: s,
          l1: si.l1,
          l2: si.l2
        });
        let G = si.G0 * (j - si.i1) / (j - si.i2);
        let x = si.x0 * (s + si.l1) / (s * (s + si.l2));
        let t = i * si.dt;
        let row = {
          s,
          j,
          I: j / 10000,
          G,
          x,
          t,
          Z: -si.s0 + si.Vn * t
        }

        so.push(row);
        let zNext = -si.s0 + si.Vn * (t + si.dt);
        let error = Math.abs(100 * (s - so[i - 1].s) / so[i - 1].s);
        console.log(zNext, error)
      } while (i < 10);
    }
  }
}

function getJ(pars) {
  let numerator = (pars.U0 - pars.Fi) * pars.x0 * (pars.si + pars.l1);
  let denominator = pars.si * (pars.si + pars.l2);
  return numerator / denominator;
}

function getG(pars) {
  return pars.G0 * (pars.ji - pars.i1) / (pars.ji - pars.i2);
}
</script>
