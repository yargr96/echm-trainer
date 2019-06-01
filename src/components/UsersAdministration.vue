<template>
  <div>
    <h1 class="text-center">Список пользователей</h1>
    <table class="table table-bordered">
      <thead>
        <th>Имя пользователя</th>
        <th>Права</th>
      </thead>
      <tbody>
        <tr v-for="(item, index) in users" :key="index">
          <td>{{ item.user_name }}</td>
          <td v-if="+item.is_admin">Администратор</td>
          <td v-else>Пользователь</td>
        </tr>
      </tbody>
    </table>
    {{ users }}
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      users: []
    }
  },
  created() {
    axios.get('/backend/users.php')
      .then(res => {
        this.users = res.data;
      })
  }
};
</script>
