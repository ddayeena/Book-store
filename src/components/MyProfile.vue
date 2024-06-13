<template>
  <div v-if="isAuthenticated">
    <div class="myprofile">
      <h1>КАБІНЕТ</h1>
      <p class="start">Вітаємо вас, {{ user.name }}! Ласкаво просимо до вашого особистого кабінету!</p>
      <div class="user_info">
        <p class="name_table">Основна інформація</p>
        <table class="user_info_table">
          <tr>
            <th>Поле</th>
            <th>Значення</th>
          </tr>
          <tr>
            <td>Логін</td>
            <td>{{ user.name }}</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>{{ user.email }}</td>
          </tr>
          <tr>
            <td>Дата приєднання</td>
            <td>{{user.created_at}}</td>
          </tr>
        </table>
      </div>

    </div>
  </div>
  <div v-else>
    <h1>КАБІНЕТ</h1>
    <p class="start">Ви не авторизовані. Будь ласка, увійдіть у свій кабінет.</p>
    <router-link to="/login" class="login">Увійти</router-link>
  </div>
</template>

<script>
import { isAuthenticated, getUser } from '@/auth';

export default {
  computed: {
    isAuthenticated() {
      return isAuthenticated();
    },
    user() {
      return getUser();
    }
  }
};
</script>

<style scoped>
.start{
    color: #666;
    font-size: 22px;
}

.login{
    padding: 10px 20px;
    background-color:#ec70a8;
    color: #fff;
    border-radius: 5px;
    border-style:none;
    cursor: pointer;
    transition: background-color 0.5s;
    font-size:22px;
    text-decoration: none;
}

.login:hover{
    background-color: #cb4d86;
}
.user_info{
    margin-left:100px;
    text-align: left;
}
.name_table{
  font-size:26px;
  font-weight:bold;
}

.user_info_table {
    width: 1000px;
    border-collapse: collapse;
    margin-top: 20px;
    font-size:22px;
}

.user_info_table th,
.user_info_table td {
    border: 1px solid #ddd;
    padding: 10px;
}

.user_info_table th {
    background-color: #f2f2f2;
    color: #333;
    font-weight:bold;
    
}
</style>
