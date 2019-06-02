<template>
  <div>
    <h1 class="text-center my-3">Список пользователей</h1>
    <table class="table table-bordered text-center">
      <thead>
        <th>Имя пользователя</th>
        <th>Права</th>
        <th>Действия</th>
      </thead>
      <tbody>
        <tr v-for="(item, index) in users" :key="index">
          <td>{{ item.user_name }}</td>
          <td v-if="+item.is_admin">Администратор</td>
          <td v-else>Пользователь</td>
          <td>
            <button 
              class="btn btn-sm btn-success"
              @click="showChangePasswordPopup(item.user_name)">Изменить пароль</button>
            <button 
              class="btn btn-sm btn-danger" 
              @click="deleteUser(item.user_name)">Удалить пользователя</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div>
      <button class="btn btn-success" @click="showAddUserPopup">Добавить пользователя</button>
      {{ userToChangePassword }}
      {{ newPassword }}
    </div>

    <transition name="fade">
      <div class="popup text-center" v-if="showAddUser">
        <form 
          class="popup__form bg-light p-5 rounded"
          @submit.prevent="addUser"
        >
          <h3>Добавить пользователя</h3>
          <hr>
          <div class="mb-2">
            <input v-model.lazy="newUserData.name" class="form-control" placeholder="Имя" type="text">
          </div>
          <div class="mb-2">
            <input v-model.lazy="newUserData.password" class="form-control" placeholder="Пароль" type="password">
          </div>
          <label class="d-block">
            <input v-model.lazy="newUserData.isAdmin" type="checkbox">
            С правами администратора
          </label>
          <hr>
          <input class="btn btn-success" type="submit" value="Добавить">
        </form>
        <div class="popup__overlay" @click="hideAddUserPopup"></div>
      </div>
    </transition>

    <transition name="fade">
      <div class="popup" v-if="showChangePassword">
        <form @submit.prevent="changePassword" class="popup__form bg-light p-5 rounded text-center">
          <h3>Введите новый пароль для пользователя {{ userToChangePassword }}</h3>
          <input 
            placeholder="Пароль" 
            type="password" 
            class="form-control mb-3"
            v-model="newPassword">
          <button class="btn btn-success btn-block">Изменить пароль</button>
        </form>
        <div class="popup__overlay" @click="hideChangePasswordPopup"></div>
      </div>
    </transition>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      users: [],
      showAddUser: false,
      showChangePassword: false,
      userToChangePassword: null,
      newPassword: '',
      newUserData: {
        name: '',
        password: '',
        isAdmin: false
      }
    };
  },
  methods: {
    getUsers() {
      let query = JSON.stringify({
        query_type: "get_users"
      });

      axios
        .post("/backend/", `query=${query}`)
        .then(res => {
          if (typeof res.data !== "object") 
            throw new Error(res.data);
          this.users = res.data;
        })
        .catch(err => {
          this.users = [];
          console.error(err);
        });
    },

    addUser() {
      if (!this.newUserData.name || !this.newUserData.password) {
        alert('Введите имя пользователя и пароль!');
        return;
      }

      let query = {
        query_type: 'add_user',
        payload: {
          name: this.newUserData.name,
          password: this.newUserData.password,
          isAdmin: this.newUserData.isAdmin,
        }
      }

      axios.post('/backend/', `query=${JSON.stringify(query)}`)
        .then(res => {
          if (res.data) {
            this.getUsers();
            this.hideAddUserPopup();
            this.newUserData.name = '';
            this.newUserData.password = '';
            this.newUserData.isAdmin = false;
          } else {
            alert('Такой пользователь уже есть');
          }
        })
    },

    deleteUser(user_name) {
      if (!confirm('Вы точно хотите удалить пользователя ' + user_name + '?'))
        return;

      let query = {
        query_type: 'delete_user',
        payload: {
          name: user_name
        }
      }

      axios.post('/backend/', `query=${JSON.stringify(query)}`)
        .then(res => {
          this.getUsers();
        })
    },

    changePassword() {
      if (!this.userToChangePassword || !this.newPassword) {
        alert('Нужно вести пароль');
        return;
      }

      let query = {
        query_type: 'change_password',
        payload: {
          name: this.userToChangePassword,
          password: this.newPassword
        }
      }

      axios.post('/backend/', `query=${JSON.stringify(query)}`)
        .then(res => {
          if (res.data) {
            alert('Пароль успешно изменён');
            this.hideChangePasswordPopup();
          } else {
            alert('Не удалось изменить пароль');
          }
        })
    },

    showAddUserPopup() {
      this.showAddUser = true;
    },

    hideAddUserPopup(e) {
      this.showAddUser = false;
    },

    showChangePasswordPopup(user_name) {
      this.userToChangePassword = user_name;
      this.showChangePassword = true;
    },

    hideChangePasswordPopup() {
      this.showChangePassword = false;
      this.userToChangePassword = null;
      this.newPassword = '';
    }
  },
  created() {
    this.getUsers();
  }
};
</script>

<style lang="scss">
.popup {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;

  &__form {
    cursor: initial;
    z-index: 2;
  }

  &__overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.7);
    cursor: pointer;
    transition: all 0.2s;
    z-index: 1;

    &:hover {
      background-color: rgba(0, 0, 0, 0.8);
    }
  }
}

.fade-enter-active, .fade-leave-active {
  transition: opacity .2s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
  opacity: 0;
}
</style>
