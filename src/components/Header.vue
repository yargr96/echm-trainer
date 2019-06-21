<template>
  <header class="header bg-dark py-2">
    <div class="container-fluid">
      <div class="row justify-content-around align-items-center">
        <div class="col-md-4 d-flex align-items-center">
          <a href="javascript:void(0)">
            <h5 class="text-light">
              ECHM-trainer
            </h5>
          </a>
        </div>
        <div class="col-md-4 text-right">
          <button
            @click="logout" 
            class="btn btn-secondary rounded-pill"
            v-if="this.$store.state.role"
          >Выйти</button>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import AccountIcon from './AccountIcon'


export default {
  methods: {
    logout() {
      this.$store.state.role = "";
      this.$router.push("/");
    }
  }
};
</script>

<style lang="scss">
.header {
  height: 80px;
  z-index: 10;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;

  & > .container-fluid {
    height: 100%;
    & > .row {
      height: 100%;
    }
  }
}
</style>
