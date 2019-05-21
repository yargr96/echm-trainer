<template>
  <div id="app">
    <app-header></app-header>
    <app-login></app-login>
    <app-footer></app-footer>
  </div>
</template>

<script>
import AppLogin from './components/Login'
import AppHeader from './components/Header'
import AppFooter from './components/Footer'

export default {
  components: {
    AppLogin,
    AppHeader,
    AppFooter
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
    padding-bottom: 100px;
  }
</style>
