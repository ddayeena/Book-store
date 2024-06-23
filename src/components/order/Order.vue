<template>
  <div>
    <h1>ОФОРМИТИ ПОКУПКУ</h1>
    <form @submit.prevent="makeOrder" class="order">
      <div class="delivery">
        <p>Виберіть спосіб доставки:</p>
        <select id="deliveryType" v-model="deliveryType" @change="updateDeliveryCost">
          <option value="Нова пошта">Нова пошта</option>
          <option value="Укр пошта">Укр пошта</option>
        </select>
      </div>

      <div class="address">
        <p>Введіть адресу:</p>
        <input type="text" v-model="town" name="town" placeholder="Введіть місто" class="input-field" required>
        <input type="text" v-model="street" name="street" placeholder="Введіть вулицю" class="input-field" required>
        <input type="text" v-model="street_number" name="street_number" placeholder="Введіть номер вулиці" class="input-field" required>
      </div>

      <div class="payment">
        <p>Виберіть спосіб оплати:</p>
        <select id="payment" v-model="paymentType" name="paymentType" required>
          <option value="Оплата картою">Оплата картою</option>
          <option value="Післяоплата">Післяоплата</option>
        </select>
        <div v-if="paymentType === 'Оплата картою'">
          <input type="text" v-model="card" name="card" placeholder="Введіть номер карти" class="input-field" @input="formatCardNumber">
        </div>

        <p>Сума замовлення - {{total_price}}</p>
        <p>Вартість доставки - {{ deliveryCost }} грн</p>
        <p>Всього до сплати: {{ totalPriceWithDelivery }} грн</p>
      </div>

      <button type="submit" class="next-btn">Надіслати замовлення</button>

      <p class="error">{{ error }}</p>
    </form>
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
      deliveryCost: 64,
      error: '' 
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
    formatCardNumber() {
      let cleaned = ('' + this.card).replace(/\D/g, '');
      let match = cleaned.match(/.{1,4}/g);
      if (match) {
        this.card = match.join(' ');
      }
    },
    makeOrder() {
      let cleanedCardNumber = this.card.replace(/\s+/g, '');

      if (this.town.length < 2) {
        this.error = "Введіть повну назву міста";
        return;
      }
      if (this.street.length < 2) {
        this.error = "Введіть повну назву вулиці";
        return;
      }
      if ((this.street_number.length < 1 || this.street_number.length > 4)) {
        this.error = "Введіть коректний номер вулиці";
        return;
      }
      if (this.paymentType === 'Оплата картою' && (cleanedCardNumber.length !== 16 || isNaN(cleanedCardNumber))) {
        this.error = "Номер карти повинен містити 16 цифр";
        return;
      }

      axios.post('http://localhost/Book-Store/backend/makeOrder.php', {
        user_id: this.user.id,
        cart_items: this.cart_items,
        total_price: this.totalPriceWithDelivery,
        deliveryType: this.deliveryType,
        paymentType: this.paymentType,
        town: this.town,
        street: this.street,
        street_number: this.street_number,
        card: cleanedCardNumber
      })
      .then(response => {
        if (response.data.message === "Замовлення оформлене успішно") {
          this.$router.push('/confirmation');
        } else {
          this.error = response.data.message;
        }   
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
  margin-bottom: 200px;
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

.error {
  color: red;
  margin-top: 5px;
  font-size: 22px;
}
</style>
