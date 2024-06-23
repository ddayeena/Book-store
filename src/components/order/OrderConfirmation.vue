<template>
<div class="order-confirmation">
    <h1>Замовлення підтверджено!</h1>
    <p class="start">Дякуємо за вашу покупку</p>
    <img src="/src/assets/smile.jpg" alt="smile-photo">
    <p class="start">У вашому кабінеті з'явилось нове замовлення! Очікуйте на його підтвердження</p>

    <router-link to="/catalog" ><button class="back-to-catalog">Назад до покупок</button></router-link>
</div>

</template>

<script>

</script>

<style >
  .start{
    color: #666;
    font-size: 22px;
  }
  .back-to-catalog{
        border-style:none;
    background: none;
    color:rgb(59, 81, 126);
    font-size:20px;
    font-style:italic;
    text-decoration: underline;
    border-radius:15px;
    transition: background-color 0.5s;
    height:40px;
    margin-top:100px;
    font-size:28px;
  }

  .back-to-catalog:hover{
    color:#fff;
    background:rgb(64, 91, 147);
  }
</style>