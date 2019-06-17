<template>
  <div>
    <form @submit.prevent="calculate" v-if="!calculated">
      <table class="table">
        <thead>
          <tr>
            <th colspan="3" class="text-center">Исходные данные</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="3" class="text-center">Ограничения первого рода</td>
          </tr>
          <tr class="text-center">
            <td>
              <input v-model="firstRestrictions.Vn.min" type="text" class="form-control form-control-sm">
            </td>
            <td><= Скорость подачи электрод-инструмента, мкм/мин <=</td>
            <td>
              <input v-model="firstRestrictions.Vn.max" type="text" class="form-control form-control-sm">
            </td>
          </tr>
          <tr class="text-center">
            <td>
              <input v-model="firstRestrictions.U0.min" type="text" class="form-control form-control-sm">
            </td>
            <td><= Заданное напряжение в момент наибольшего сближения электродов, В <=</td>
            <td>
              <input v-model="firstRestrictions.U0.max" type="text" class="form-control form-control-sm">
            </td>
          </tr>

          <tr>
            <td colspan="3" class="text-center">Ограничения второго рода</td>
          </tr>
          <tr>
            <td colspan="2">Скорость подачи электрод-инструмента, мкм/мин ></td>
            <td>
              <input v-model="secondRestrictions.Vn" type="text" class="form-control form-control-sm">
            </td>
          </tr>
          <tr>
            <td colspan="2">Заданное напряжение в момент наибольшего сближения электродов, В <</td>
            <td>
              <input v-model="secondRestrictions.U0" type="text" class="form-control form-control-sm">
            </td>
          </tr>

          <tr>
            <td colspan="3" class="text-center">Погрешность вычислений</td>
          </tr>
          <tr>
            <td colspan="2">Максимальная погрешность целевой функции, %</td>
            <td>
              <input v-model="error" type="text" class="form-control form-control-sm">
            </td>
          </tr>

          <tr>
            <td colspan="3" class="text-center">Стартовая точка</td>
          </tr>
          <tr>
            <td colspan="2">Скорость подачи электрод-инструмента, мкм/мин</td>
            <td>
              <input v-model="startPoint.Vn" type="text" class="form-control form-control-sm">
            </td>
          </tr>
          <tr>
            <td colspan="2">Заданное напряжение в момент наибольшего сближения электродов, В</td>
            <td>
              <input v-model="startPoint.U0" type="text" class="form-control form-control-sm">
            </td>
          </tr>
        </tbody>
      </table>

      <button 
        class="btn btn-success btn-block"
        :disabled="!parametersChecked"
      >Рассчёт</button>
    </form>

    <div class="alert alert-primary my-3" v-if="calculated">
      <table class="table">
        <thead>
          <tr>
            <th colspan="3">Оптимальные значения</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Заданное напряжение в момент наибольшего сближения электродов:</td>
            <td>53.788</td>
            <td>В</td>
          </tr>
          <tr>
            <td>Скорость подачи электрод-инструмента:</td>
            <td>12.304</td>
            <td>мкм/мин</td>
          </tr>
          <tr>
            <td>Значение целевой функции (Амплитудная плотность тока):</td>
            <td>0.511</td>
            <td>А/см<sub>2</sub></td>
          </tr>
        </tbody>
      </table>
      <button @click="calculated = false" class="btn btn-block btn-primary">Назад</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      calculated: false,
      firstRestrictions: {
        Vn: {
          min: 30,
          max: 90
        },
        U0: {
          min: 4.5,
          max: 13.5
        }
      },
      secondRestrictions: {
        Vn: 40,
        U0: 10
      },
      error: 0.1,
      startPoint: {
        U0: 50,
        Vn: 11
      }
    }
  },
  computed: {
    parametersChecked() {
      const list = [
        this.firstRestrictions.Vn.min,
        this.firstRestrictions.Vn.max,
        this.firstRestrictions.U0.min,
        this.firstRestrictions.U0.max,
        this.secondRestrictions.Vn,
        this.secondRestrictions.U0,
        this.error,
        this.startPoint.U0,
        this.startPoint.Vn,
      ];

      for (let i = 0; i < list.length; i++) {
        if (list[i] === null || list[i] === "")
          return false;
        if (isNaN(+list[i]))
          return false;
      }

      return true;
    }
  },
  methods: {
    calculate() {
      this.calculated = true;
    }
  }
}
</script>
