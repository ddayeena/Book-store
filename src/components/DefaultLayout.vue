<template>
  <div>
    <header>
      <div class="logo">
        <router-link to='/'>
          <img src="\src\assets\logo.png" alt="Книжковий Магазин Логотип">
        </router-link>
        <h1 class="logo_name">ЛІТЕРАЛІЯ</h1>
      </div>
      <nav>
        <router-link to="/">Головна</router-link>
        <div class="dropdown">
          <router-link to="/catalog">Каталог</router-link>
          <div class="dropdown-content">
            <router-link to="/catalog/detective">Детективи</router-link>
            <router-link to="/catalog/love-novels">Романтична проза</router-link>
            <router-link to="/catalog/thrillers-and-horror">Трилери та жахи</router-link>
            <router-link to="/catalog/fantasy">Фентезі</router-link>
            <router-link to="/catalog/comics">Комікси та манги</router-link>
          </div>
        </div>
        <router-link to="/novelty">Новинки</router-link>
        <router-link to="/about">Про нас</router-link>
        <router-link to="/cart" class="cart_opt">Кошик</router-link>
        <router-link to="/myprofile" class="myprofile_opt">Мій кабінет</router-link>
        <button v-if="isUserAuthenticated" @click="logoutUser" class="logout">Вийти</button>
      </nav>
    </header>
    <main>
      <router-view></router-view>
    </main>
    <footer>
      <p>&copy; 2024 Книжковий Магазин. Всі права захищені.</p>
    </footer>
  </div>
</template>

<script>
import { isUserAuthenticated, logoutUser } from '@/auth';

export default {
  name: 'DefaultLayout',
  data() {
    return {
      isUserAuthenticated: false
    };
  },
  watch: {
    $route(to, from) {
      this.isUserAuthenticated = isUserAuthenticated();
    }
  },
  methods: {
    logoutUser() {
      logoutUser();
      this.$router.push('/');
    }
  }
};
</script>

<style scoped>
*{
  font-family: Arial, sans-serif;
}
body {
  margin: 0;
  padding: 0;
  background-color: #f8f8f8;
}

header {
  background-color: #fff;
  border-bottom: 1px solid #ddd;
  padding: 20px 0;
  text-align: center;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo img {
  height: 70px;
  margin-left: 30px;
  float: left;
}

.logo {
  width: 320px;
}

.logo_name{
  color:#333;
  font-weight: bolder;
}

nav {
  display: flex;
  justify-content: center;
  position: relative;
}

nav a {
  color: #333;
  margin: 0 30px;
  text-decoration: none;
  font-weight: bold;
  font-size: 20px;
  position: relative;
  border-radius: 20px;
  padding-right: 30px;
  padding-left: 30px;
}

nav a:hover {
  color: #fff;
  background-color: #ec70a8;
}

.dropdown {
  position: relative;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  border-radius: 20px;
  z-index:1;
}

.dropdown-content a {
  color: #333;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  color: #fff;
  background-color: #ec70a8;
}

.dropdown:hover .dropdown-content {
  display: block;
}
.logout{
  color: #333;
  font-size:20px;
  border:none;
  background:none;
  font-weight:bold;
  cursor:pointer;
  border-left:1px solid #333;
}
.logout:hover{
  color:#ec70a8;
  text-decoration:underline;
}
.cart_opt{
  background-color:#ec70a8;
  color:#fff;
}
.cart_opt:hover{
  background-color:#fff;
  color:#333;
  border:1px solid#ec70a8;

}
.myprofile_opt{
  border:1px solid#ec70a8;
}
main {
  padding: 20px;
  text-align: center;
}

footer {
  background-color: #333;
  color: white;
  padding: 10px 0;
  text-align: center;
  position: fixed;
  width: 100%;
  bottom: 0;
  left:0;
}
</style>
