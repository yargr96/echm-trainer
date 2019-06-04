<template>
  <div class="sidebar border-right bg-white">
    <div class="list-group list-group-flush">
      <a 
        href="javascript:void(0)" 
        class="list-group-item sidebar-list__item"
        v-for="(item, index) in list"
        :key="index"
      >{{ item }}</a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      list: [
        'Модуль администрирования учётных записей',
        'Модуль математического моделирования'
      ]
    }
  }
};
</script>

<style lang="scss">
.sidebar {
  position: fixed;
  left: 0;
  top: 80px;
  bottom: 0;
  width: 300px;
  overflow: auto;
}

.sidebar-list__item {
  transition: all .2s;
  color: #343a40;

  &:hover {
    background-color: #343a40;
    color: #ffffff !important;
    text-decoration: none;
  }
}
</style>
