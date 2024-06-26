<template>
  <div class="full-page">      
    <header>
      <router-link to="/manage-users" class="nav-link">Користувачі</router-link>
      <router-link to="/manage-books" class="nav-link">Книги</router-link>
      <router-link to="/users-orders" class="nav-link">Замовлення</router-link>
      <router-link to="/admin" class="nav-link">Мій кабінет</router-link>
      <button @click="logoutAdmin" class="logout" v-if="isAdminAuthenticated">Вийти</button>
    </header>

    <router-view></router-view>
    
    <footer>
      <p>&copy; 2024 Книжковий Магазин. Всі права захищені.</p>
    </footer>
  </div>
</template>

<script>
import { isAdminAuthenticated, logoutAdmin } from '@/auth';

export default {
  name: 'FullPage',
  data() {
    return {
      isAdminAuthenticated: false
    };
  },
  watch: {
    $route(to, from) {
      this.isAdminAuthenticated = isAdminAuthenticated();
    }
  },
  methods: {
    logoutAdmin() {
      logoutAdmin();
      this.$router.push('/log-admin');
    }
  }
};
</script>

<style scoped>
*{
    font-family: Arial, sans-serif;
} 
.full-page {
  width: 100%;
  height: 100%;
}

header {
  background-color: #999;
  height: 100px;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}

.nav-link {
  color: #333;
  text-decoration: none;
  margin-right: 20px;
  font-size: 20px;
}

.nav-link:hover,
.router-link-active {
  text-decoration: underline;
}


.logout {
  margin-right: 10px;
  padding: 10px 20px;
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  border-left: 1px solid #777;
  transition: background-color 0.5s;
  color: #333;
}

.logout:hover {
  background-color: #666; 
}

footer {
  background-color: #333;
  color: white;
  padding: 10px 0;
  text-align: center;
  position: fixed;
  width: 100%;
  bottom: 0;
  left: 0;
}
</style>
