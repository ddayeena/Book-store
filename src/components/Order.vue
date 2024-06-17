<template>
  <div class="order">
    <h1>ОФОРМИТИ ПОКУПКУ</h1>
    <div class="delivery">
        <label for="delivery">Виберіть спосіб доставки:</label>
        <select id="delivery" v-model="selectedDelivery">
            <option value="Нова пошта">Нова пошта</option>
            <option value="Укр пошта">Укр пошта</option>
        </select>
        <p v-if="selectedDelivery === 'Нова пошта'">Вартість доставки - 64 грн</p>
        <p v-else>Вартість доставки - 44 грн</p>
    </div>

    <div class="address">
        <input type="text" v-model="address" placeholder="Введіть місто доставки">
    </div>

    <div class="payment">
        <label for="payment">Виберіть спосіб оплати:</label>
        <select id="payment" v-model="selectedPayment">
            <option value="Оплата картою">Оплата картою</option>
            <option value="Післяоплата">Післяоплата</option>
        </select>
    </div>
  </div>
</template>



<script>
export default {
  data() {
    return {
      selectedDelivery: 'Нова пошта', 
      selectedPayment: 'Оплата картою'
    };
  }
}
</script>


<style scoped>

</style>

