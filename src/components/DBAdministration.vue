<template>
  <div>
    <h2 class="text-center my-3">Администрирование базы данных</h2>
    <div class="row mb-3">
      <div class="col-6">Выберите таблицу</div>
      <div class="col-6">
        <select v-model="currentTable" class="form-control">
          <option selected value="machines">Станки</option>
          <option value="materials">Материалы</option>
          <option value="electrolytes">Элеткролиты</option>
        </select>
      </div>
    </div>
    <!-- Станки -->
    <table v-if="currentTable == 'machines'" class="table">
      <thead>
        <tr>
          <th>Название</th>
          <th>A</th>
          <th>P<sub>el</sub></th>
          <th>S</th>
          <th>f</th>
          <th>t<sub>imp</sub></th>
          <th>ψ</th>
          <th>s<sub>0</sub></th>
          <th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, index) in machines"
          :key="index"
        >
          <td>{{ item.name }}</td>
          <td>{{ item.A }}</td>
          <td>{{ item.Pel }}</td>
          <td>{{ item.S }}</td>
          <td>{{ item.f }}</td>
          <td>{{ item.timp }}</td>
          <td>{{ item.psi }}</td>
          <td>{{ item.s0 }}</td>
          <td>
            <button 
              class="btn btn-danger btn-sm"
              @click="del('machines', index)"
            >Удалить</button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Материалы -->
    <table v-if="currentTable == 'materials'" class="table">
      <thead>
        <tr>
          <th>Название</th>
          <th>G0</th>
          <th>i1</th>
          <th>i2</th>
          <th>l1</th>
          <th>l2</th>
          <th>ρ</th>
          <th>Действия</th>
        </tr>
      </thead>
      <tbody>
        
        <tr
          v-for="(item, index) in materials"
          :key="index"
        >
          <td>{{ item.name }}</td>
          <td>{{ item.G0 }}</td>
          <td>{{ item.i1 }}</td>
          <td>{{ item.i2 }}</td>
          <td>{{ item.l1 }}</td>
          <td>{{ item.l2 }}</td>
          <td>{{ item.rho }}</td>
          <td>
            <button 
              class="btn btn-danger btn-sm"
              @click="del('materials', index)"
            >Удалить</button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Электролиты -->
    <table v-if="currentTable == 'electrolytes'" class="table">
      <thead>
        <tr>
          <th>Название</th>
          <th>χ <sub>0</sub></th>
          <th>C</th>
          <th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, index) in electrolytes"
          :key="index"
        >
          <td>{{ item.name }}</td>
          <td>{{ item.x0 }}</td>
          <td>{{ item.C }}</td>
          <td>
            <button 
              class="btn btn-danger btn-sm"
              @click="del('electrolytes', index)"
            >Удалить</button>
          </td>
        </tr>
      </tbody>
    </table>

    <h5>Добавить запись</h5>
    <!-- Add machine -->
    <table v-if="currentTable == 'machines'" class="table">
      <thead>
        <tr>
          <th>Название</th>
          <th>A</th>
          <th>P<sub>el</sub></th>
          <th>S</th>
          <th>f</th>
          <th>t<sub>imp</sub></th>
          <th>ψ</th>
          <th>s<sub>0</sub></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input v-model="newMachine.name" class="form-control" type="text"></td>
          <td><input v-model="newMachine.A" class="form-control" type="text"></td>
          <td><input v-model="newMachine.Pel" class="form-control" type="text"></td>
          <td><input v-model="newMachine.S" class="form-control" type="text"></td>
          <td><input v-model="newMachine.f" class="form-control" type="text"></td>
          <td><input v-model="newMachine.timp" class="form-control" type="text"></td>
          <td><input v-model="newMachine.psi" class="form-control" type="text"></td>
          <td><input v-model="newMachine.s0" class="form-control" type="text"></td>
        </tr>
      </tbody>
    </table>
    <!-- Add material -->
    <table v-if="currentTable == 'materials'" class="table">
      <thead>
        <tr>
          <th>Название</th>
          <th>G0</th>
          <th>i1</th>
          <th>i2</th>
          <th>l1</th>
          <th>l2</th>
          <th>ρ</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input v-model="newMaterial.name" class="form-control" type="text"></td>
          <td><input v-model="newMaterial.G0" class="form-control" type="text"></td>
          <td><input v-model="newMaterial.i1" class="form-control" type="text"></td>
          <td><input v-model="newMaterial.i2" class="form-control" type="text"></td>
          <td><input v-model="newMaterial.l1" class="form-control" type="text"></td>
          <td><input v-model="newMaterial.l2" class="form-control" type="text"></td>
          <td><input v-model="newMaterial.rho" class="form-control" type="text"></td>
        </tr>
      </tbody>
    </table>
    <!-- Add electrolyte -->
    <table v-if="currentTable == 'electrolytes'" class="table">
      <thead>
        <tr>
          <th>Название</th>
          <th>χ <sub>0</sub></th>
          <th>C</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input v-model="newElectrolyte.name" class="form-control" type="text"></td>
          <td><input v-model="newElectrolyte.x0" class="form-control" type="text"></td>
          <td><input v-model="newElectrolyte.C" class="form-control" type="text"></td>
        </tr>
      </tbody>
    </table>
    <button @click="add" class="btn btn-success">Добавить</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentTable: "machines",
      machines: [
        {
          name: 'ET-300',
          A: 150,
          Pel: 150,
          S: 2,
          f: 47,
          timp: 1.2,
          psi: 0.5,
          s0: 300
        }
      ],
      materials: [
        {
          name: 'сталь 12Х18Н9Т',
          G0: 0.64,
          i1: 15.3,
          i2: -3.2,
          l1: 0,
          l2: 44.9,
          rho: 7.9
        }
      ],
      electrolytes: [
        {
          name: "NaNO3",
          x0: 8.48,
          C: 8
        }
      ],
      newMachine: {
        name: '',
        A: null,
        Pel: null,
        S: null,
        f: null,
        timp: null,
        psi: null,
        s0: null
      },
      newMaterial: {
        name: '',
        G0: null,
        i1: null,
        i2: null,
        l1: null,
        l2: null,
        rho: null
      },
      newElectrolyte: {
        name: "",
        x0: null,
        C: null
      }
    }
  },
  methods: {
    add() {
      if (this.currentTable == 'machines') {
        this.machines.push(this.newMachine);
      } else if (this.currentTable == 'materials') {
        this.materials.push(this.newMaterial);
      } else if (this.currentTable == 'electrolytes') {
        this.electrolytes.push(this.newElectrolyte);
      }
    },
    del(table, index) {
      this[table].splice(index, 1);
    }
  }
}
</script>
