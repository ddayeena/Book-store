<template>
  <div class="profile-container">
    <div v-if="isUserAuthenticated">
      <div class="profile-header">
        <h1>КАБІНЕТ</h1>
        <p class="start">Вітаємо, {{ user.name }}! Ласкаво просимо до вашого особистого кабінету!</p>
      </div>

      <div class="user-info-section">
        <h2>Основна інформація</h2>
        <table class="user-info-table">
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

        <div class="order-info">
        <h2>Ваші замовлення</h2>
            <div v-if="orders.length > 0">
              <div v-for="(order, index) in orders" :key="order.order_id" class="order-item">
              <router-link :to="{name:'OrderDetails', params:{order_id: order.order_id}}">

                <div class="order-details">

                  <div class="order-extra-details">
                  <p class="order-number">Замовлення №{{ index+1}}</p>
                    <p class="order-details-text">
                      Місто: {{ order.town }}<br>
                      Вулиця: {{ order.street }} {{ order.street_number }}<br>
                      Доставка на пошту: {{ order.type }}
                    </p>
                    <p class="order-details-text">
                      Дата замовлення: {{ order.order_date }}<br>
                      Тип оплати: {{ order.payment_method }}<br>
                      Сума замовлення: {{order.total_price}}
                    </p>
                    <div v-if="order.status==='В процесі'" class="status-square-process">{{order.status}}</div>
                    <div v-if="order.status==='Доставлено'" class="status-square-done">{{order.status}} </div>
                  </div>

                </div>
              </router-link>
            </div>
            </div>
            <div v-if="orders.length==0" class="start">У вас немає замовлень</div>
       </div>

  </div>

    <div v-else>
      <h1>КАБІНЕТ</h1>
      <p class="start">Ви не авторизовані. Будь ласка, увійдіть у свій кабінет.</p>
      <router-link to="/login" class="login-button">Увійти</router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { isUserAuthenticated, getUser } from '@/auth';

export default {
  data() {
    return {
      orders: [],
      cartMessage: '',
    };
  },
  computed: {
    isUserAuthenticated() {
      return isUserAuthenticated();
    },
    user() {
      return getUser();
    }
  },
  created() {
    if (this.isUserAuthenticated) {
      this.fetchOrders(this.user.id);
    }
  },
  methods: {
    fetchOrders(userId) {
      axios.get(`http://localhost/Book-Store/database/getOrders.php?user_id=${userId}`)
        .then(response => {
          if (response.data && response.data.orders) {
            this.orders = response.data.orders;
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
.profile-container {
  margin-bottom: 200px;
}

.start {
  color: #666;
  font-size: 22px;
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

.user-info-section {
  text-align: left;
}

.user-info-table {
  width: 100%;
  margin-top: 20px;
  font-size: 22px;
}

.user-info-table th,
.user-info-table td {
  border: 1px solid #ddd;
  padding: 10px;
}

.user-info-table th {
  background-color: #f2f2f2;
  color: #333;
  font-weight: bold;
}

.order-info {
  margin-top: 100px;
}

.order-item {
  margin-top: 20px;
  padding: 10px;
  border: 1px solid #ddd;
  box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2);
  transition: background-color 0.5s;
}

.order-item:hover{
  background-color: rgb(206, 206, 206);
}
a{
  text-decoration: none;
  color:#333;
}

.order-number {
  font-weight: bold;
  font-style: italic;
  margin-right: 10px;
  font-size: 22px;
}

.order-extra-details {
  display: flex;
  flex: 1;
  margin-right: 10px;
  justify-content: space-between;
  align-items: center;
}

.order-details-text {
  font-size: 22px;
  line-height: 1.5;
  text-align: justify;
}

.status-square-process {
  padding: 10px 15px;
  border-radius: 5px;
  background-color: #4CAF50;
  color: #fff;
  min-width: 100px;
  font-weight: bold;
  justify-content: center;
}

.status-square-done {
  padding: 10px 15px;
  border-radius: 5px;
  background-color: rgb(50, 50, 150);
  color: #fff;
  min-width: 100px;
  font-weight: bold;
  justify-content: center;
}
</style>