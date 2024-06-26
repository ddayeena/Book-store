<template>
  <div class="orders-container">
    <div v-if="isAdminAuthenticated">
      <div v-if="admin.role === 'admin'" class="order-info">
        <h1>ЗАМОВЛЕННЯ</h1>

        <div class="filter-container">
          <label for="order-status-filter">Обрати статус замовлення:</label>
          <select id="order-status-filter" v-model="selectedStatus">
            <option value="">Усі замовлення</option>
            <option value="В процесі">В процесі</option>
            <option value="Доставлено">Доставлено</option>
          </select>
        </div>

        <div v-if="filteredOrders.length > 0">
          <div v-for="(order, index) in filteredOrders" :key="order.order_id" class="order-item">
            <router-link :to="{ name: 'ManageOrder', params: { order_id: order.order_id, user_id: order.user_id }}">
              <div class="order-details">
                <div class="order-extra-details">
                  <p class="order-number">Замовлення №{{ index + 1 }}</p>
                  <p class="order-details-text">ID користувача: {{ order.user_id }}</p>
                  <p class="order-details-text">
                    Місто: {{ order.town }}<br>
                    Вулиця: {{ order.street }} {{ order.street_number }}<br>
                    Доставка на пошту: {{ order.type }}
                  </p>
                  <p class="order-details-text">
                    Дата замовлення: {{ order.order_date }}<br>
                    Тип оплати: {{ order.payment_method }}<br>
                    Сума замовлення: {{ order.total_price }}
                  </p>
                  <div v-if="order.status === 'В процесі'" class="status-square-process">{{ order.status }}</div>
                  <div v-if="order.status === 'Доставлено'" class="status-square-done">{{ order.status }}</div>
                </div>
              </div>
            </router-link>
          </div>
        </div>
        <div v-else class="start">У вас немає замовлень з обраним статусом</div>
      </div>

      <div v-else>
        <div class="no-access">
          <h3>ЗАМОВЛЕННЯ</h3>
          <p>⛔</p>
          <p>У вас немає доступу до цієї сторінки. Будь ласка, зв'яжіться з адміном для надання доступу.</p>
        </div>
      </div>
    </div>

    <div v-else class="login">
      <h1>ЗАМОВЛЕННЯ</h1>
      <p class="start">Ви не авторизовані. Будь ласка, увійдіть у свій кабінет.</p>
      <router-link to="/log-admin" class="login-button">Увійти</router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { isAdminAuthenticated, getAdmin } from '@/auth';

export default {
  data() {
    return {
      orders: [],
      selectedStatus: '', 
    };
  },
  computed: {
    isAdminAuthenticated() {
      return isAdminAuthenticated();
    },
    admin() {
      return getAdmin();
    },
    filteredOrders() {
      if (!this.selectedStatus) {
        return this.orders; 
      } else {
        return this.orders.filter(order => order.status === this.selectedStatus);
      }
    },
  },
  created() {
    if (this.isAdminAuthenticated) {
      this.fetchOrders();
    }
  },
  methods: {
    fetchOrders() {
      axios.get(`http://localhost/Book-Store/database/getAllOrders.php`)
        .then(response => {
          if (response.data && response.data.orders) {
            this.orders = response.data.orders;
          } else {
            this.orders = [];
          }
        })
        .catch(error => {
          console.error('Помилка запиту:', error);
          this.orders = [];
        });
    },
  },
};
</script>

<style scoped>
@import url('@/assets/css/admin_loginstyle.css');

.orders-container {
  text-align: center;
  margin-bottom: 100px;
  color: #333;
}

.order-item {
  margin-top: 20px;
  padding: 10px;
  border: 1px solid #ddd;
  box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2);
  transition: background-color 0.5s;
  border-radius: 8px;
}

.order-info {
  margin-top: 50px;
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
