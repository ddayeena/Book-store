<template>
  <div class="order-details-container">
    <h1>Інформація</h1>
    <p>Деталі замовлення</p>
    <p>Статус: {{order_details.status}}</p>
    <p>Спосіб доставки: {{order_details.type}}</p>
    <p>Місто: {{order_details.town}}</p>
    <p>Адреса: {{order_details.street}} {{order_details.street_number}}</p>
    <p>Спосіб оплати: {{order_details.payment_method}}</p>
    <p>Всього до сплати: {{order_details.total_price}}</p>

    <div v-for="order in order_items" :key="order.order_id" class="order-item">
      <img :src="order.img_src" alt="Book Cover" class="book-cover">
      <p>{{order.book_name}}</p>
      <p>{{order.book_author}}</p>
      <p>Кількість {{order.quantity}}</p>
      <p>Ціна: {{order.book_price}}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { isAuthenticated, getUser } from '@/auth';

export default {
  props: ['order_id'],
  data() {
    return {
      order_items: [],
      order_details:{}
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
      this.getOrder();
    }
  },
  methods: {
    getOrder() {
      axios.get('http://localhost/Book-Store/backend/getOrderDetails.php', {
        params: {
          order_id: this.order_id,
          user_id: this.user.id
        }
      })
      .then(response => {
        this.order_items = response.data.order_items;
        this.order_details=response.data.order_details;
      })
      .catch(error => {
        console.error("There was an error!", error);
      });
    },
  }
};
</script>

<style scoped>
.order-details-container{
  margin-bottom:200px;
}
.order-item {
  margin-bottom: 10px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
}
</style>
