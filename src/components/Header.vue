<template>
  <header class="header bg-dark py-2">
    <div class="container-fluid">
      <div class="row justify-content-around">
        <div class="col-md-4">
          <a href="javascript:void(0)">
            <h5 class="text-light">
              Программный комплекс для обучения операторов управлению элекрохимическим станком
            </h5>
          </a>
        </div>
        <div class="col-md-4">
          <account-icon></account-icon>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import AccountIcon from './AccountIcon'

export default {
  components: {
    AccountIcon
  }
};
</script>

<style lang="scss">

</style>
