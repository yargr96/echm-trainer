<template>
  <div>
		<ul class="nav nav-tabs my-3">
			<li class="nav-item">
				<a 
					@click.prevent="activeTab = 'inputs'"
					class="nav-link"
					:class="{ active: activeTab == 'inputs'}"
					href="#">Входные данные</a>
			</li>
			<li class="nav-item">
				<a 
					@click.prevent="activeTab = 'results'"
					class="nav-link"
					:class="{ active: activeTab == 'results'}"
					href="#">Выходные данные</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">График</a>
			</li>
		</ul>
    <form @submit.prevent="calculate" v-if="activeTab == 'inputs'">
      <h3 class="text-center my-3">Входные параметры</h3>

      <div class="row text-center table-header">
        <div class="col-lg-4">
          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text">Станок</label>
            </div>
            <select 
							class="custom-select" 
							v-model="currentMachine"
						>
							<option value="" selected>Выберите</option>
              <option 
								v-for="(item, key, index) in machines"
								:key="index"
							>{{ key }}</option>
            </select>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text">Электролит</label>
            </div>
            <select 
							class="custom-select"
							v-model="currentElectrolyte"
						>
							<option value="" selected>Выберите</option>
              <option 
								v-for="(item, key, index) in electrolytes"
								:key="index"
							>{{ key }}</option>
            </select>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text">Материал</label>
            </div>
            <select 
							class="custom-select"
							v-model="currentMaterial"
						>
							<option value="" selected>Выберите</option>
              <option 
								v-for="(item, key, index) in materials"
								:key="index"
							>{{ key }}</option>
            </select>
          </div>
        </div>
      </div>
      <!-- /row -->
      <hr>
      <div class="row">
				<!-- Параметры станка -->
        <div class="col-lg-4">
          <div 
						v-for="(item, index) in machineParameters"
						:key="index"
						class="input-group mb-3"
					>
            <div class="input-group-prepend">
              <span class="input-group-text">{{ item.alias }} =</span>
            </div>
            <input type="text" class="form-control" v-model.lazy="item.value">
            <div class="input-group-append">
              <span class="input-group-text" v-html="item.units"></span>
            </div>
          </div>
        </div>
				<!-- Параметры электролита -->
        <div class="col-lg-4">
          <div 
						v-for="(item, index) in electrolyteParameters"
						:key="index"
						class="input-group mb-3"
					>
            <div class="input-group-prepend">
              <span class="input-group-text">{{ item.alias }} =</span>
            </div>
            <input type="text" class="form-control" v-model.lazy="item.value">
            <div class="input-group-append">
              <span class="input-group-text" v-html="item.units"></span>
            </div>
          </div>
        </div>
				<!-- Параметры материала -->
        <div class="col-lg-4">
          <div 
						v-for="(item, index) in materialParameters"
						:key="index"
						class="input-group mb-3"
					>
            <div class="input-group-prepend">
              <span class="input-group-text">{{ item.alias }} =</span>
            </div>
            <input type="text" class="form-control" v-model.lazy="item.value">
            <div class="input-group-append">
              <span class="input-group-text" v-html="item.units"></span>
            </div>
          </div>
        </div>
      </div> <!-- /row -->
			<hr>
			<h3 class="text-center my-3">Варьируемые параметры</h3>
			<div class="row text-center">
				<div class="col-lg-6">
					<table class="table">
						<tr>
							<td>
								η
							</td>
							<td>
								<input type="text" class="form-control" v-model.lazy="variableParameters.n">
							</td>
						</tr>
						<tr>
							<td>
								U
							</td>
							<td>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">От</span>
									</div>
									<input type="text" class="form-control" v-model.lazy="variableParameters.U.from">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">До</span>
									</div>
									<input type="text" class="form-control" v-model.lazy="variableParameters.U.to">
								</div>
							</td>
						</tr>
						<tr>
							<td>
								Введите погрешность вычислений
							</td>
							<td>
								<input type="text" class="form-control" v-model.lazy="variableParameters.e">
							</td>
						</tr>
					</table>
				</div>
				<div class="col-lg-6">
					<table class="table">
						<tr>
							<td>
								Введите количество итераций
							</td>
							<td>
								<input type="text" class="form-control" v-model.lazy="variableParameters.it">
							</td>
						</tr>
						<tr>
							<td>
								Введите межэлектродный зазор
							</td>
							<td>
								<input type="text" class="form-control" v-model.lazy="variableParameters.gap">
							</td>
						</tr>
						<tr>
							<td>
								Введите dU
							</td>
							<td>
								<input type="text" class="form-control" v-model.lazy="variableParameters.dU">
							</td>
						</tr>
					</table>
					<input
						type="button" 
						value="Загрузить стандартные"
						@click="loadStandardVariables"
						class="btn btn-success btn-block"
					>
				</div>
			</div>
			<div>
				<button class="btn btn-primary btn-block">Рассчитать</button>
			</div>
    </form>
		<div class="results text-center" v-if="activeTab == 'results'">
			<h3>Результаты рассчёта</h3>
			<table class="table">
				<thead>
					<th>i (шаг)</th>
					<th>V (мм/мин)</th>
					<th>U (В)</th>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>4</td>
					</tr>
				</tbody>
			</table>
		</div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
	data() {
		return {
			activeTab: 'inputs',
			machineParameters: {
				I: {
					value: null,
					units: 'А'
				},
				T: {
					value: null,
					units: 'с'
				},
				t: {
					value: null,
					units: 'с'
				},
				Kimp: {
					value: null,
					units: null
				},
				f: {
					value: null,
					units: 'Гц'
				},
			},
			electrolyteParameters: {
				S: {
					value: null,
					units: 'м <sup>2</sup>',
				},
				sigma: {
					value: null,
					units: 'См/м',
					alias: 'σ'
				}
			},
			materialParameters: {
				rho: {
					value: null,
					units: 'кг/м<sup>3</sup>',
					alias: 'ρ'
				},
				Kv: {
					value: null,
					units: 'м<sup>3</sup>/Кл'
				}
			},
			variableParameters: {
				n: null,
				U: {
					from: null,
					to: null
				},
				e: null,
				it: null,
				gap: null, // зазор
				dU: null
			},
			machines: {},
			electrolytes: {},
			materials: {},
			currentMachine: '',
			currentElectrolyte: '',
			currentMaterial: '',
		}
	},

	methods: {
		getInputParameters() {
			let query = JSON.stringify({
				query_type: 'get_input_parameters'
			});
			
			axios.post('/backend/', `query=${query}`)
				.then(res => {
					console.log(res.data);
					for (let i in res.data.machines) {
						this.$set(this.machines, i, res.data.machines[i]);
					}
					for (let i in res.data.electrolytes) {
						this.$set(this.electrolytes, i, res.data.electrolytes[i]);
					}
					for (let i in res.data.materials) {
						this.$set(this.materials, i, res.data.materials[i]);
					}
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

		loadStandardVariables() {
			this.variableParameters.n = 0.8;
			this.variableParameters.U.from = 10;
			this.variableParameters.U.to = 35;
			this.variableParameters.e = 0.001;
			this.variableParameters.it = 100;
			this.variableParameters.gap = 2.5;
			this.variableParameters.dU = 1.25;
		},

		calculate() {
			console.log(getVn(
				this.variableParameters.n, 
				this.materialParameters.Kv.value,
				this.machineParameters.Kimp.value,
				this.machineParameters.t.value,
				this.electrolyteParameters.S.value,
				this.machineParameters.f.value,
			))
		}
	},

	watch: {
		currentMachine(val) {
			let props = this.machines[val];
			if (!props) {
				for (let i in this.machineParameters) {
					this.machineParameters[i].value = null;
				}
				return;
			}
			
			this.machineParameters.I.value = this.machines[val].I;
			this.machineParameters.Kimp.value = this.machines[val].Kimp;
			this.machineParameters.T.value = this.machines[val].Period;
			this.machineParameters.t.value = this.machines[val].t;
			this.machineParameters.f.value = this.machines[val].f;
		},

		currentElectrolyte(val) {
			console.log(this.electrolytes[val]);
			console.log(this.electrolyteParameters);
			let props = this.electrolytes[val];
			if (!props) {
				for (let i in this.electrolyteParameters) {
					this.electrolyteParameters[i].value = null;
				}
				return;
			}

			this.electrolyteParameters.S.value = this.electrolytes[val].S;
			this.electrolyteParameters.sigma.value = this.electrolytes[val].sigma;
		},

		currentMaterial(val) {
			let props = this.materials[val];
			if (!props) {
				for (let i in this.materialParameters) {
					this.materialParameters[i].value = null;
				}
				return;
			}
			console.log(this.materials[val]);
			console.log(this.materialParameters);
			this.materialParameters.Kv.value = this.materials[val].Kv;
			this.materialParameters.rho.value = this.materials[val].rho;
		}
	},
	
	created() {
		this.addAliases();
		this.getInputParameters();
	}
};

function getVn(n, Kv, Kimp, t, S, f) {
	console.log(n, Kv, Kimp, t, S, f);
	
	return (n * Kv * Kimp * t) / (S * (1 / f));
}
</script>

<style lang="scss" scoped>
.input-group-text {
  width: 100%;
}

.input-group-prepend {
  width: 20%;
  min-width: 75px;
}

.input-group-append {
  width: 20%;
  min-width: 60px;
}

.table-header .input-group-prepend {
  width: auto;
}
</style>
