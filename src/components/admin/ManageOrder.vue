<template>
  <div class="order-details-container">
    
     <router-link to="/users-orders"><p class="back">НАЗАД</p></router-link>
    <div class="order-details">
      <h2>Деталі замовлення</h2>
      <table>
        <tr>
          <th>Поле</th>
          <th>Значення</th>
        </tr>
        <tr>
          <td>ID користувача:</td>
          <td>{{ user_id }}</td>
        </tr>
        <tr>
          <td>Ім'я користувача:</td>
          <td>{{ order_details.user_name }}</td>
        </tr>
        <tr>
          <td>Статус:</td>
          <td>{{ order_details.status }}</td>
        </tr>
        <tr>
          <td>Дата замовлення:</td>
          <td>{{ order_details.order_date }}</td>
        </tr>
        <tr>
          <td>Спосіб доставки:</td>
          <td>{{ order_details.type }}</td>
        </tr>
        <tr>
          <td>Місто:</td>
          <td>{{ order_details.town }}</td>
        </tr>
        <tr>
          <td>Адреса:</td>
          <td>вул. {{ order_details.street }} {{ order_details.street_number }}</td>
        </tr>
        <tr>
          <td>Спосіб оплати:</td>
          <td>{{ order_details.payment_method }}</td>
        </tr>
        <tr class="total-price">
          <td>Всього до сплати:</td>
          <td>{{ order_details.total_price }} грн</td>
        </tr>
      </table>
    </div>

    <div v-for="(order, index) in order_items" :key="order.book_id" class="order-item">

      <p class="number">{{ index + 1 }}</p>
      <img :src="order.img_src" alt="Book Cover" class="book-cover">

      <div class="order-info">
        <p class="book-name">{{ order.book_name }}</p>
        <p class="book-author">{{ order.book_author }}</p>
        <p>{{ order.book_price }} грн × {{ order.quantity }} шт. = <b>{{ order.book_price * order.quantity }} грн</b></p>
      </div>

    </div>

    <div v-if="order_details.status==='В процесі'" class="confirm-order">
      <button class="confrim-order-btn" @click="sendOrder">Надіслати замовлення</button>
    </div>

    <div v-if="order_details.status ==='Доставлено'" class="confirm-order">
        <button class="finish-order-btn">Замовлення доставлене успішно</button>
    </div>

  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    order_id: {
      type: Number,
      required: true
    },
    user_id: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      order_items: [],
      order_details: {}
    };
  },
  created() {
    this.getOrder();
  },
  methods: {
    getOrder() {
      axios.get('http://localhost/Book-Store/database/getOrderDetails.php', {
        params: {
          order_id: this.order_id,
          user_id: this.user_id
        }
      })
      .then(response => {
        if (response.data) {
          this.order_items = response.data.order_items;
          this.order_details = response.data.order_details;
        }
      })
      .catch(error => {
        console.error("There was an error!", error);
      });
    },
    sendOrder(){
      axios.post('http://localhost/Book-Store/database/sendOrder.php', {
        order_id: this.order_id
      })
      .then(response => {
        if(response.data.message){
          this.order_details.status = 'Доставлено';
          console.log(response.data.message);
        }
      })
      .catch(error => {
        console.error("There was an error!", error);
      });
    },
  }
};
</script>

<style scoped>
.back{
  font-size:22px;
  color:#333;
  font-weight:bold;
  border-right: 1px solid #333;
  display:inline-block; 
  padding:10px;
}
.back:hover{
  color:#666;
}
.order-details-container {
  margin:50px 0px 100px 0px;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0px 4px 10px 4px rgba(0,0,0,0.1);
}

.order-details {
  margin-bottom: 50px;
}

.order-details table {
  width: 100%;
  margin-top: 20px;
  font-size: 22px;
  text-align: left;
}

.order-details td, .order-details th {
  padding: 10px 15px;
  border: 1px solid #ddd;
}

.order-details th {
  background-color: #f2f2f2;
  color: #333;
  font-weight: bold;
}

.number {
  font-size: 22px;
  margin-right: 20px;
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
  font-size: 18px;
  text-align: left;
}

.total-price {
  color: rgb(170, 32, 32);
  font-weight: bold;
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

.book-author {
  font-size: 20px;
  color: rgb(59, 81, 126); 
}

.confrim-order-btn{
  margin-top:50px;
  padding: 20px 30px;
  background-color: #4CAF50;
  color: #fff;
  border-radius: 5px;
  border-style: none;
  cursor: pointer;
  transition: background-color 0.5s;
  font-size:22px;
}

.confrim-order-btn:hover {
  background-color: #2e7531;
}

.finish-order-btn{
  margin-top:50px;
  padding: 20px 30px;
  background-color: rgb(90, 90, 190);
  border:5px solid black;
  color: #999;
  border-radius: 5px;
  border-style: none;
  cursor: pointer;
  transition: background-border 0.5s;
  font-size:22px;
}
</style>
