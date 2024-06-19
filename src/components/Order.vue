<template>
  <h1>ОФОРМИТИ ПОКУПУКУ</h1>
  <div class="order">
    <div class="delivery">
        <p>Виберіть спосіб доставки:</p>
        <select id="deliveryType" v-model="deliveryType" @change="updateDeliveryCost">
            <option value="Нова пошта">Нова пошта</option>
            <option value="Укр пошта">Укр пошта</option>
        </select>
    </div>

    <div class="address">
        <p>Введіть адресу:</p>
        <input type="text" v-model="town" placeholder="Введіть місто" class="input-field">
        <input type="text" v-model="street" placeholder="Введіть вулицю" class="input-field">
        <input type="text" v-model="street_number" placeholder="Введіть номер вулиці" class="input-field">
    </div>

    <div class="payment">
        <p>Виберіть спосіб оплати:</p>
        <select id="payment" v-model="paymentType">
            <option value="Оплата картою">Оплата картою</option>
            <option value="Післяоплата">Післяоплата</option>
        </select>
        <div v-if="paymentType === 'Оплата картою'">
          <input type="text" v-model="card" placeholder="Введіть номер карти" class="input-field">
        </div>

        <p>Сума замовлення - {{total_price}}</p>
        <p>Вартість доставки - {{ deliveryCost }} грн</p>
        <p>Всього до сплати:{{ totalPriceWithDelivery }} грн</p>
    </div>

    <button class="next-btn" @click="makeOrder">Надіслати замовлення</button>
  </div>
</template>

<script>
import axios from 'axios';
import { getUser } from '@/auth';

export default {
  data() {
    return {
      deliveryType: 'Нова пошта',
      paymentType: 'Оплата картою',
      town: '',
      street: '',
      street_number: '',
      card: '',
      cart_items: [],
      total_price: 0,
      deliveryCost: 64 
    };
  },
  computed: {
    user() {
      return getUser();
    },
    totalPriceWithDelivery() {
      return this.total_price + this.deliveryCost;
    }
  },
  created() {
    if (this.$route.query.cartItems) {
      this.cart_items = JSON.parse(decodeURIComponent(this.$route.query.cartItems));
    }
    if (this.$route.query.totalPrice) {
      this.total_price = parseFloat(this.$route.query.totalPrice);
    }
  },
  methods: {
    updateDeliveryCost() {
      this.deliveryCost = this.deliveryType === 'Нова пошта' ? 64 : 44;
    },
    makeOrder() {

      axios.post('http://localhost/Book-Store/backend/makeOrder.php', {
        user_id: this.user.id,
        cart_items: this.cart_items,
        total_price: this.totalPriceWithDelivery,
        deliveryType: this.deliveryType,
        paymentType: this.paymentType,
        town: this.town,
        street: this.street,
        street_number: this.street_number,
        card: this.card
      })
      .then(response => {
        console.log(response.data.message);
        this.$router.push('/confirmation');
      })
      .catch(error => {
        console.error('Помилка оформлення замовлення:', error);
      });
    }
  }
};
</script>

<style scoped>
.order {
  max-width: 800px;
  margin: auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
}

h1 {
  margin-bottom: 20px;
}

.delivery, .address, .payment {
  margin-bottom: 50px;
}

select, input {
  width: 100%;
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.input-field {
  margin-top: 10px;
}

p {
  margin-top: 20px;
  margin-bottom: 5px;
}

.next-btn {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: #fff;
  border-radius: 5px;
  border-style: none;
  cursor: pointer;
  transition: background-color 0.5s;
}

.next-btn:hover {
  background-color: #2e7531;
}
</style>
