<template>
    <div class="login">
        <h1>КАБІНЕТ</h1>
        <p class="start">Введіть дані для авторизації</p>
        <form @submit.prevent="sendData">
            <input type="text" v-model="userName" name="userName" placeholder="Логін" required>
            <input type="password" v-model="userPass" name="userPass" placeholder="Пароль" required>
            <input type="email" v-model="userEmail" name="userEmail" placeholder="Email" required>
            <div class="new_acc">
                <p class="quest">Ще не створили власну сторінку?</p>
                <router-link to="/register"><button class="reg_but">Натисніть тут</button></router-link>
            </div>
            <p class="error">{{ error }}</p>
            <button type="submit" class="log_but">Увійти</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { setUserToken, setUser } from '@/auth';

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
                email: this.userEmail,
                role: 'user'
            };

            const url = 'http://localhost/Book-Store/database/checkUser.php';

            axios.post(url, userData, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.data.message === "Користувач знайдений") {
                        setUserToken(response.data.token);
                        setUser(response.data.user); 
                        this.$router.push('/myprofile');
                    } else {
                        this.error = response.data.message;
                    }
                })
                .catch(error => {
                    this.error = 'Помилка при з\'єднанні з сервером.';
                    console.error('Помилка:', error);
                });
        },
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

.log_but {
  padding: 10px 20px;
  background-color:#ec70a8;
  color: #fff;
  border-radius: 5px;
  border-style:none;
  cursor: pointer;
  transition: background-color 0.5s;
  font-size:22px;
}

.log_but:hover {
  background-color: #cb4d86;
}

.new_acc{
    display:flex;
    justify-content: space-between;
}

.quest{
    color:rgb(59, 81, 126);
    font-size: 20px;
}

.reg_but{
    border-style:none;
    background: none;
    color:rgb(59, 81, 126);
    font-size:20px;
    font-style:italic;
    text-decoration: underline;
    border-radius:15px;
    transition: background-color 0.5s;
    height:40px;
    margin-top:10px;
}

.reg_but:hover{
    color:#fff;
    background:rgb(64, 91, 147);
}

</style>