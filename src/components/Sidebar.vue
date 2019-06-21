<template>
  <div class="sidebar border-right bg-white">
    <div class="list-group list-group-flush">
      <router-link 
        class="list-group-item sidebar-list__item"
        v-for="(item, key, index) in list"
        :key="index"
        :to="item.link"
      >{{ item.text }}</router-link>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      adminList: [
        {
          text: 'Модуль администрирования базы данных',
          link: '/db-admin'
        },
        {
          text: 'Модуль администрирования учётных записей',
          link: '/users-administration'
        },
        {
          text: 'Инструкции',
          link: '/training'
        },
        {
          text: 'Модуль математического моделирования',
          link: '/math-module'
        },
      ],
      userList: [
        {
          text: 'Инструкции',
          link: '/training'
        },
        {
          text: 'Модуль математического моделирования',
          link: '/math-module'
        },
      ]
    }
  },
  computed: {
    list() {
      let role = this.$store.state.role;
      if (role === 'admin')
        return this.adminList;
      else if (role === 'user')
        return this.userList;
      else return [];
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

  & .router-link-exact-active {
    background-color: #343a40;
    color: #ffffff !important;
    border-right: 5px solid #00a8ff;
  }
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
