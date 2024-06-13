<template>
  <div v-if="isAuthenticated">
    <h1>КАБІНЕТ</h1>
    <h3>Вітаємо вас!</h3>
  </div>
  <div v-else>
    <h1>КАБІНЕТ</h1>
    <p class="start">Ви не авторизовані. Будь ласка, увійдіть у свій кабінет.</p>
    <router-link to="/login" class="login">Увійти</router-link>
  </div>
</template>

<script>
import { isAuthenticated } from '@/auth';

export default {
  computed: {
    isAuthenticated() {
      return isAuthenticated();
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


</style>
