<template>
  <div class="profile-container">
    <div v-if="isAdminAuthenticated">
      <header>
        <button v-if="isAdminAuthenticated" @click="logoutAdmin" class="logout">Вийти</button>
      </header>


      <div class="welcome">
        <p class="start">Вітаємо, {{ admin.name }}!</p>
      </div>

        <div class="order-info">
        <h1>ЗАМОВЛЕННЯ</h1>
            <div v-if="orders.length > 0">
              <div v-for="(order, index) in orders" :key="order.order_id" class="order-item">
              <router-link :to="{name:'ManageOrder', params:{order_id: order.order_id, user_id: order.user_id}}">

                <div class="order-details">

                  <div class="order-extra-details">
                    <p class="order-number">Замовлення №{{ index+1}}</p>
                    <p class="order-details-text">
                      ID користувача: {{order.user_id}}
                    </p>
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
      <h1>АДМІН</h1>
      <p class="start">Ви не авторизовані. Будь ласка, увійдіть у свій кабінет.</p>
      <router-link to="/log-admin" class="login-button">Увійти</router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { isAdminAuthenticated, getAdmin, logoutAdmin } from '@/auth';

export default {
  data() {
    return {
      orders: [],
      cartMessage: '',
    };
  },
  computed: {
    isAdminAuthenticated() {
      return isAdminAuthenticated();
    },
    admin() {
      return getAdmin();
    }
  },
  created() {
    if (this.isAdminAuthenticated) {
      this.fetchOrders();
    }
  },
  methods: {
    logoutAdmin() {
      logoutAdmin();
      this.$router.push('/log-admin');
    },
    fetchOrders() {
      axios.get(`http://localhost/Book-Store/database/getAllOrders.php`)
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
header {
  background-color: #999;
  width: 100%;
  height: 100px;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  left:0;
  right:0;
}

.profile-container {
  text-align: center;
  
}

.logout {
  margin-right:10px;
  padding: 10px 20px;
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  border-left: 1px solid #777;
  transition: background-color 0.5s;
  color:#333;
}

.logout:hover {
  background-color: #666; 
}

.start {
  color: #666;
  font-size: 26px;
  text-align: center;
  margin-top: 20px; 
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

.order-info {
  margin-top: 50px;
}

.order-item {
  margin-top: 20px;
  padding: 10px;
  border: 1px solid #ddd;
  box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2);
  transition: background-color 0.5s;
}

.order-item:hover {
  background-color: rgb(206, 206, 206);
}

a {
  text-decoration: none;
  color: #333;
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
  background-color: #4caf50;
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
