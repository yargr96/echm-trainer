<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 position-relative">
        <app-sidebar></app-sidebar>
      </div>
      <div class="col-md-10">
        <app-article-body></app-article-body>
      </div>
    </div>
  </div>
</template>

<script>
import AppArticleBody from './ArticleBody'
import AppSidebar from './Sidebar'

export default {
  components: {
    AppArticleBody,
    AppSidebar
  }
};
</script>

<style lang="scss">
</style>
