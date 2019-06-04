<template>
  <div>
    <form @submit.prevent="123">
      <h3 class="text-center my-3">Входные параметры</h3>

      <div class="row text-center table-header">
        <div class="col-lg-4">
          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text">Станок</label>
            </div>
            <select class="custom-select">
              <option selected>ET-300</option>
            </select>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text">Электролит</label>
            </div>
            <select class="custom-select">
              <option selected>NACl</option>
            </select>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text">Материал</label>
            </div>
            <select class="custom-select">
              <option selected>ВТ</option>
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
								n
							</td>
							<td>
								<input type="text" class="form-control">
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
									<input type="text" class="form-control">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">До</span>
									</div>
									<input type="text" class="form-control">
								</div>
							</td>
						</tr>
						<tr>
							<td>
								Введите погрешность вычислений
							</td>
							<td>
								<input type="text" class="form-control">
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
								<input type="text" class="form-control">
							</td>
						</tr>
						<tr>
							<td>
								Введите межэлектродный зазор
							</td>
							<td>
								<input type="text" class="form-control">
							</td>
						</tr>
						<tr>
							<td>
								Введите dU
							</td>
							<td>
								<input type="text" class="form-control">
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div>
				<button class="btn btn-primary btn-block">Рассчитать</button>
			</div>
    </form>
		{{machines}}
		{{electrolytes}}
		{{materials}}
  </div>
</template>

<script>
import axios from 'axios'

export default {
	data() {
		return {
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
			machines: {},
			electrolytes: {},
			materials: {}
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
		}
	},
	
	created() {
		this.addAliases();
		this.getInputParameters();
	}
};
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
