<template>
    <div class="admin-profile">
        <div v-if="isAdminAuthenticated">
            <h1>МІЙ КАБІНЕТ</h1>
            <div class="welcome">
                <p class="start">Вітаємо, {{ admin.name }}!</p>
            </div>

            <div class="admin-info-section">
                <h2>Основна інформація</h2>
                <table class="admin-info-table">
                  <tr>
                      <th>Поле</th>
                      <th>Значення</th>
                  </tr>
                  <tr>
                      <td>Логін</td>
                      <td>{{ admin.name }}</td>
                  </tr>
                  <tr>
                      <td>Email</td>
                      <td>{{ admin.email }}</td>
                  </tr>
                  <tr>
                      <td>Дата приєднання</td>
                      <td>{{ admin.created_at }}</td>
                  </tr>
                  <tr>
                      <td>Роль</td>
                      <td>{{ admin.role }}</td>
                  </tr>
                </table>
            </div>

            <div class="link-container">
              <router-link to="/users-orders" class="link">Перегляньте останні замовлення читачів!</router-link>
              <router-link to="/manage-books" class="link">Наповніть книгарню новими книгами!</router-link>
              <router-link to="/manage-users" class="link">Перегляньте останніх зареєстрованих користувачів!</router-link>
            </div>

        </div>

        <div v-else class="login">
            <h1>МІЙ КАБІНЕТ</h1>
            <p class="start">Ви не авторизовані. Будь ласка, увійдіть у свій кабінет.</p>
            <router-link to="/log-admin" class="login-button">Увійти</router-link>
        </div>

    </div>
</template>

<script>
import {isAdminAuthenticated, getAdmin} from '@/auth.js';

export default{
    computed: {
    isAdminAuthenticated() {
      return isAdminAuthenticated();
    },    
    admin() {
      return getAdmin();
    }
  },
}

</script>

<style scoped>
@import url('@/assets/css/admin_loginstyle.css');
.admin-profile{
  text-align: center;
  color:#333;
}
.admin-info-section {
  text-align: left;
}

.admin-info-table {
  width: 100%;
  margin-top: 20px;
  font-size: 22px;
}

.admin-info-table th,
.admin-info-table td {
  border: 1px solid #ddd;
  padding: 10px;
}

.admin-info-table th {
  background-color: #f2f2f2;
  color: #333;
  font-weight: bold;
}

.link{
  font-size:#333;
  text-decoration: none;
  font-size:22px;
  padding:30px;
  margin-top:30px;
  transition: background-color 0.5s;
}
.link:hover{
  text-decoration: underline;
  background-color: #ddd;
}

.link-container{
  text-align:center;
  display:flex;
  flex-direction: column;
}


</style>
