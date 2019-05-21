<template>
  <div class="container login">
    <div class="row justify-content-center">
      <div class="col-md-4 border rounded-lg bg-dark text-white p-4 my-5">
        <h2>Авторизация</h2>
        <login-form></login-form>
      </div>
    </div>
  </div>
</template>

<script>
import LoginForm from "./LoginForm";

export default {
  components: {
    LoginForm
  }
};
</script>

<style lang="scss">
 .login {
   text-align: center;
 }
</style>
