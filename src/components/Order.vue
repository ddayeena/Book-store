<template>
  <h1>ОФОРМИТИ ПОКУПКУ</h1>
  <div class="order">
    <div class="delivery">
        <p>Виберіть спосіб доставки:</p>
        <select id="deliveryType" v-model="deliveryType">
            <option value="Нова пошта">Нова пошта</option>
            <option value="Укр пошта">Укр пошта</option>
        </select>
        <p v-if="deliveryType === 'Нова пошта'">Вартість доставки - 64 грн</p>
        <p v-else>Вартість доставки - 44 грн</p>
    </div>

    <div class="address">
        <p>Введіть адресу:</p>
        <input type="text" v-model="town" placeholder="Введіть місто" class="input-field">
        <input type="text" v-model="street" placeholder="Введіть вулицю" class="input-field">
        <input type="text" v-model="number" placeholder="Введіть номер вулиці" class="input-field">
    </div>

    <div class="payment">
        <p>Виберіть спосіб оплати:</p>
        <select id="payment" v-model="paymentType">
            <option value="Оплата картою">Оплата картою</option>
            <option value="Післяоплата">Післяоплата</option>
        </select>
        <div v-if="paymentType==='Оплата картою'">
          <input type="text" v-model="card" placeholder="Введіть номер карти" class="input-field">
        </div>
        <p>Всього до сплати:</p>
    </div>

    <button class="next-btn" @click="makeOrder">Надіслати замовлення</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      deliveryType: 'Нова пошта', 
      paymentType: 'Оплата картою',
      town: '',
      street: '',
      number: '',
      card: ''
    };
  },
  methods:{
    makeOrder(){
      this.$router.push('/confirmation');
    },
  }
}
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
  font-size:22px;

}

.input-field {
  margin-top:10px;
  font-size:22px;

}

p {
  margin-top: 20px;
  font-size:22px;
  margin-bottom:5px;
}

.next-btn{
    padding: 10px 20px;
  background-color: #4CAF50;
  color: #fff;
  border-radius: 5px;
  border-style: none;
  cursor: pointer;
  transition: background-color 0.5s;
  font-size: 22px;
}

.next-btn:hover{
  background-color: #2e7531;
}
</style>
