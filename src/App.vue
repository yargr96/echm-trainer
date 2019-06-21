<template>
  <div id="app">
    <app-header></app-header>
    <!-- <app-login></app-login> -->
    <app-workspace v-if="loggedIn"></app-workspace>
    <app-login v-else></app-login>
  </div>
</template>

<script>
import AppHeader from './components/Header'
import AppLogin from './components/Login'
import AppWorkspace from './components/Workspace'
import Login from './components/Login'

export default {
  components: {
    AppHeader,
    AppLogin,
    AppWorkspace,
    AppLogin
  },
  name: 'app',
  data () {
    return {
      
    }
  },
  computed: {
    loggedIn() {
      if (!this.$store.state.role)
        return false;
      return true;
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
