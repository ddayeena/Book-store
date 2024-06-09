<template>
    <div class="login">
        <h1>КАБІНЕТ</h1>
        <p class="start">Введіть дані для авторизації</p>
        <input type="text" v-model="userName" placeholder="Ім'я">
        <input type="password" v-model="userPass" placeholder="Пароль">
        <input type="email" v-model="userEmail" placeholder="Email">
        <p class="error">{{ error }}</p>
        <button @click="sendData">Відправити</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            userName: '',
            userPass: '',
            userEmail: '',
            error: ''
        };
    },
    methods: {
        sendData() {
            const userData = {
                name: this.userName,
                password: this.userPass,
                email: this.userEmail
            };

            // Встановіть URL-адресу сервера для перевірки користувача в базі даних
            const url = 'http://localhost/Book-Store/backend/checkUser.php'; // Припустимо, що це ваш URL-адрес сервера

            axios.post(url, userData, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    // Якщо користувач існує, перенаправте його на сторінку з вітанням
                    if (response.data.message === "Користувач знайдений") {
                        this.$router.push('/myprofile');
                    } else {
                        this.error = response.data.message;
                    }
                })
                .catch(error => {
                    // Обробка помилок, якщо користувач не знайдений
                    this.error = 'Помилка при з\'єднанні з сервером.';
                    console.error('Помилка:', error);
                });
        }
    }
};
</script>

<style scoped>
input[type="text"],
input[type="password"],
input[type="email"] {
  width: 100%;
  height:40px;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size:22px;
}
.login{
    width:800px;
    margin:0 auto;
}
.start{
    color: #666;
    font-size: 22px;
}
.error {
  color: red;
  margin-top: 5px;
  font-size:22px;
}

button {
  padding: 10px 20px;
  background-color:#ec70a8;
  color: #fff;
  border-radius: 5px;
  border-style:none;
  cursor: pointer;
  transition: background-color 0.3s;
  font-size:22px;
}

button:hover {
  background-color: rgb(207, 190, 190);
  color:#ec70a8;
}

</style>
