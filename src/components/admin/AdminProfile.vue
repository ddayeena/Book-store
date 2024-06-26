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
                </table>
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
.admin-profile{
  text-align: center;
  color:#333;
  margin-top: 50px;

}
.start {
  font-size: 26px;
  text-align: center;
  margin-top: 20px; 
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

.login-button {
  padding: 10px 20px;
  background-color: #ec70a8;
  color: #fff;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  transition: background-color 0.5s;
  font-size: 22px;
  text-decoration: none;
}

.login-button:hover {
  background-color: #cb4d86;
} 

.login{
  margin-top:200px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  padding:50px;
  display:inline-block;
}
</style>
