<template>
  <form @submit.prevent="authorize" class="login-form">
    <label>
      Логин <br>
      <input v-model="login" type="text" class="form-control">
    </label>
    <label class="mb-3">
      Пароль <br>
      <input v-model="password" type="password" class="form-control">
    </label>
    <br>
    <button class="btn btn-light">Войти</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      login: "",
      password: ""
    }
  },
  methods: {
    authorize() {
      setTimeout(() => {
        if (this.login == 'admin' && this.password == 'admin') {
          this.$store.state.role = "admin";
        } else if (this.login == 'user' && this.password == 'user') {
          this.$store.state.role = "user";
        } else {
          this.$store.state.role = "";
          alert("Неверный логин или пароль!");
        }
      }, 300)
    }
  }
}
</script>

<style lang="scss" scoped>

</style>
