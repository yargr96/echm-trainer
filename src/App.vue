<template>
  <div id="app">
    <app-header></app-header>
    <!-- <app-login></app-login> -->
    <app-workspace></app-workspace>
  </div>
</template>

<script>
import AppHeader from './components/Header'
import AppLogin from './components/Login'
import AppWorkspace from './components/Workspace'

export default {
  components: {
    AppHeader,
    AppLogin,
    AppWorkspace,
  },
  name: 'app',
  data () {
    return {
      
    }
  }
}
</script>

<style lang="scss">
  #app {
    min-height: 100vh;
    position: relative;
  }
</style>
