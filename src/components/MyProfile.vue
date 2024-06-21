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
            <td>{{ user.created_at }}</td>
          </tr>
        </table>
      </div>

      <p>Ваші замовлення</p>
      <p class="start">{{ cartMessage }}</p>

      <div v-if="orders.length > 0">
        <div v-for="(order, index) in orders" :key="order.order_id" class="order-info">
          <div class="order-details">
            <p class="number">{{ index + 1 }}</p>
            <router-link :to="{ name: 'Book', params: { id: order.book_id }}">
              <img :src="order.img_src" alt="Book Cover" class="book-cover">
            </router-link>
            <div class="details">
              <router-link :to="{ name: 'Book', params: { id: order.book_id }}">
                <p class="name">{{ order.name }}</p>
              </router-link>
              <p class="author">{{ order.author }}</p>
              <p class="quantity">Кількість: {{ order.quantity }}</p>
              <p class="price">Ціна: <b>{{ order.price }}</b> грн</p>

              <p>Деталі замовлення:</p>
              <p>Дата замовлення: {{order.order_date}}</p>
              <p>Статус: {{order.status}}</p>
              <p>Тип оплати: {{order.payment_method}}</p>
            </div>
          </div>
        </div>
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
import axios from 'axios';
import { isAuthenticated, getUser } from '@/auth';

export default {
  data() {
    return {
      cartMessage: '',
      orders: [],
      total_price: 0 
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
  created() {
    if (this.isAuthenticated) {
      this.fetchOrders(this.user.id);
    }
  },
  methods: {
    fetchOrders(userId) {
      axios.get(`http://localhost/Book-Store/backend/getOrders.php?user_id=${userId}`)
        .then(response => {
          if (response.data && response.data.orders) {
            this.orders = response.data.orders;
            this.total_price = response.data.total_price;
            this.cartMessage = this.orders.length === 0 ? 'У вас немає замовлень' : `Кількість замовлень: ${this.orders.length}`;
          } else {
            this.cartMessage = 'У вас немає замовлень';
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

.login:hover{
  background-color: #cb4d86;
}

.user_info{
  margin-left: 100px;
  text-align: left;
}

.name_table{
  font-size: 26px;
  font-weight: bold;
}

.user_info_table {
  width: 1000px;
  border-collapse: collapse;
  margin-top: 20px;
  font-size: 22px;
}

.user_info_table th,
.user_info_table td {
  border: 1px solid #ddd;
  padding: 10px;
}

.user_info_table th {
  background-color: #f2f2f2;
  color: #333;
  font-weight: bold;
}

.order-info{
  display: flex;
  align-items: center;
  margin: 20px 0;
}

.book-cover{
  width:100px;
  height:150px;
  margin-right:20px;
}

.details{
  flex: 1;
}

.number {
  font-weight: bold;
  margin-right: 10px;
}

.quantity,
.price{
  margin-top: 10px;
}

.router-link{
  text-decoration: none;
}
</style>
