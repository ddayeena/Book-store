<template>
  <div class="cart">
    <h1>КОШИК</h1>
    
    <div v-if="isAuthenticated && user">
        <p class="start">{{ cartMessage }}</p>
        <ul v-if="cart_items.length > 0">
        <li v-for="(cart_item, index) in cart_items" :key="cart_item.cart_id">
            <p>Товар №{{ index + 1 }}</p>   
            <p>Книга: {{ cart_item.book_name }}</p>
            <p>Кількість: {{ cart_item.quantity }}</p>
            <p>Ціна за одиницю: {{ cart_item.unit_price }} грн</p>
        </li>
        </ul>
    </div>

    <div v-else>
      <p class="start">Ви не авторизовані. Будь ласка, увійдіть у свій кабінет для перегляду товарів</p>
      <router-link to="/login" class="login">Увійти</router-link>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import { isAuthenticated, getUser } from '@/auth'; 

export default {
  data() {
    return {
      cartMessage: '', 
      cart_items: [] 
    };
  },
  computed: {
    isAuthenticated() {
      return isAuthenticated();
    },
    user() {
      return getUser(); 
    }
  },
  mounted() {
    if (this.isAuthenticated && this.user) {
      this.checkCart(this.user.id);
    }
  },
  methods: {
    checkCart(userId) {
      axios.get(`http://localhost/Book-Store/backend/getCart.php?user_id=${userId}`)
        .then(response => {
          if (response.data && response.data.cart_items) {
            this.cart_items = response.data.cart_items;
            if (this.cart_items.length === 0) {
              this.cartMessage = 'У вас немає доданих книг';
            } else {
              this.cartMessage = `Додані книги до кошика: ${this.cart_items.length}`;
            }
          } else {
            this.cartMessage = 'Дані про кошик недоступні';
          }
        })
        .catch(error => {
          console.error('Помилка запиту:', error);
          this.cartMessage = 'Помилка отримання даних';
        });
    } 
  }
};
</script>

<style scoped>
.start {
  color: #666;
  font-size: 22px;
}

.login {
  padding: 10px 20px;
  background-color: #ec70a8;
  color: #fff;
  border-radius: 5px;
  border-style: none;
  cursor: pointer;
  transition: background-color 0.5s;
  font-size: 22px;
  text-decoration: none;
}

.login:hover {
  background-color: #cb4d86;
}
</style>
