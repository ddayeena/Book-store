<template>
  <div class="order-details-container">
    <div class="order-details">
      <h2>Деталі замовлення!!!</h2>
      <table>
        <tr>
            <th>Поле</th>
            <th>Значення</th>
        </tr>
        <tr>
          <td>Статус:</td>
          <td>{{order_details.status}}</td>
        </tr>
        <tr>
          <td>Дата замовлення:</td>
          <td>{{order_details.order_date}}</td>
        </tr>
        <tr>
          <td>Спосіб доставки:</td>
          <td>{{order_details.type}}</td>
        </tr>
        <tr>
          <td>Місто:</td>
          <td>{{order_details.town}}</td>
        </tr>
        <tr>
          <td>Адреса:</td>
          <td>вул. {{order_details.street}} {{order_details.street_number}}</td>
        </tr>
        <tr>
          <td>Спосіб оплати:</td>
          <td>{{order_details.payment_method}}</td>
        </tr>
        <tr class="total-price">
          <td>Всього до сплати:</td>
          <td>{{order_details.total_price}} грн</td>
        </tr>
      </table>
    </div>

    <div v-for="(order,index) in order_items" :key="order.order_id" class="order-item">
      <p class="number">{{index+1}}</p>
      <router-link :to="{ name: 'Book', params: { id: order.book_id }}">
        <img :src="order.img_src" alt="Book Cover" class="book-cover">
      </router-link>
      <div class="order-info">
      <router-link :to="{ name: 'Book', params: { id: order.book_id }}">
        <p class="book-name">{{order.book_name}}</p>
      </router-link>

        <p class="book-author">{{order.book_author}}</p>
        <p>{{order.book_price}} грн × {{order.quantity}} шт.  = <b>{{order.book_price*order.quantity}} грн</b></p>
      </div>
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
      order_details: {}
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
      axios.get('http://localhost/Book-Store/database/getOrderDetails.php', {
        params: {
          order_id: this.order_id,
          user_id: this.user.id
        }
      })
      .then(response => {
        this.order_items = response.data.order_items;
        this.order_details = response.data.order_details;
      })
      .catch(error => {
        console.error("There was an error!", error);
      });
    },
  }
};
</script>

<style scoped>
.order-details-container {
  margin-bottom: 200px;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.order-details {
  margin-bottom: 50px;
}

.order-details table {
  width: 100%;
  margin-top: 20px;
  font-size: 22px;
  text-align:left;
}

.order-details td {
  padding: 10px 15px;
  border: 1px solid #ddd;
}
.order-details th{
  background-color: #f2f2f2;
  color: #333;
  font-weight: bold;
  border: 1px solid #ddd;
  padding: 10px;
}
.number {
  font-size: 22px;
  margin-right:20px;
}

.order-item {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.order-item img.book-cover {
  width: 100px;
  height: 140px;
  margin-right: 50px;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.order-info {
  display: flex;
  flex-direction: column;
  font-size:18px;
  text-align:left;
}
.total-price{
  color:rgb(170, 32, 32);
  font-weight:bold;
  text-decoration: underline;
}
.order-info p {
  margin: 5px 0;
}

.book-name {
  font-size: 22px;
  font-weight: bold;
  color: #333;
}
a{
  text-decoration: none;
}
.book-name:hover {
  color: #ec70a8;
}

.book-author {
  font-size: 20px;
  color: rgb(59, 81, 126); 
}
</style>
