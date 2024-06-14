<template>
  <div class="cart">
    <h1>КОШИК</h1>
    <p>Тут знаходяться товари, які ви бажаєте придбати</p>
    <p v-if="isAuthenticated && user">
      {{ cartMessage }}
    </p>
    <p v-else>
      Ви не увійшли в систему. Будь ласка, увійдіть для перегляду свого кошика.
    </p>
  </div>
</template>

<script>
import axios from 'axios';
import { isAuthenticated, getUser } from '@/auth'; 

export default {
  data() {
    return {
      cartMessage: '' 
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
      this.checkOrderCount(this.user.id);
    }
  },
  methods: {
    checkOrderCount(userId) {
      axios.get(`http://localhost/Book-Store/backend/getOrders.php?user_id=${userId}`)
        .then(response => {
          if (response.data && response.data.order_count !== undefined) {
            const orderCount = response.data.order_count;
            if (orderCount === 0) {
              this.cartMessage = 'У вас немає доданих книг';
            } 
            else {
              this.cartMessage = `У вас є ${orderCount} книг`;
            }
          } else {
            this.cartMessage = 'Дані про замовлення недоступні';
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

<style>

</style>
