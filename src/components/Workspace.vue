<template>
  <div class="workspace">
    <app-sidebar></app-sidebar>
    <div class="container-fluid page">
      <div class="row">
        <div class="col-12">
          <!-- <app-admin-interface></app-admin-interface> -->
          <app-math-module></app-math-module>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AppSidebar from './Sidebar'
import AppAdminInterface from './AdminInterface'
import AppMathModule from './MathModule'

export default {
  components: {
    AppSidebar,
    AppAdminInterface,
    AppMathModule
  }
};
</script>

<style lang="scss">
.workspace {
  position: absolute;
  top: 0;
  left: 300px;
  right: 0;
  min-height: 100vh;
  padding-top: 80px;
}

.page {
  position: absolute;
  left: 0;
  top: 80px;
  right: 0;
  bottom: 0;
}
</style>
