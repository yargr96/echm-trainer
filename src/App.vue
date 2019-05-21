<template>
  <div id="app">
    <app-header></app-header>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 position-relative">
          <app-sidebar></app-sidebar>
        </div>
        <div class="col-md-10">
          <app-article></app-article>
        </div>
      </div>
    </div>
    <!-- <app-login></app-login> -->
    
    <app-footer></app-footer>
  </div>
</template>

<script>
import AppLogin from './components/Login'
import AppHeader from './components/Header'
import AppFooter from './components/Footer'
import AppArticle from './components/Article'
import AppSidebar from './components/Sidebar'

export default {
  components: {
    AppLogin,
    AppHeader,
    AppFooter,
    AppArticle,
    AppSidebar
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
    position: relative;
  }
</style>
