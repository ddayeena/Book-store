<template>
  <div id="app">
    <header>
      <div class="logo">
        <img src="\src\assets\logo.png" alt="Книжковий Магазин Логотип">
        <h1>Літералія</h1>
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
        <router-link to="/cart">Кошик</router-link>
        <router-link to="/about">Про нас</router-link>
        <router-link to="/login">Кабінет</router-link>
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
import axios from 'axios';

export default {
  name: 'App',  
}
</script>

<style>
body {
  font-family: Arial, sans-serif;
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
  margin-left: 20px;
  float: left;
}

.logo {
  width: 280px;
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
}

nav a:hover {
  color: #ec70a8;
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
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
  display: block;
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
}

</style>
