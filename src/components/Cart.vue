<template>
  <div class="cart">
    <h1>КОШИК</h1>
    
    <div v-if="isUserAuthenticated && user">
      <p class="start">{{ cartMessage }}</p>

      <div v-if="cart_items.length > 0">
        <div v-for="(cart_item, index) in cart_items" :key="cart_item.cart_id" class="book-info">

          <div class="book-details">
            
            <p class="number">{{ index + 1 }}</p>   
            <router-link :to="{ name: 'Book', params: { id: cart_item.book_id }}">
              <img :src="cart_item.img_src" alt="Book Cover" class="book-cover">
            </router-link>

            <div class="details">
              <router-link :to="{ name: 'Book', params: { id: cart_item.book_id }}">
                <p class="name">{{ cart_item.name }}</p>
              </router-link>
              <p class="author">{{cart_item.author}}</p>

              <div class="quantity">
                <button @click="removeFromCart(cart_item.cart_details_id)" class="quantity-btn">-</button>
                <p class="quantity-text">Кількість:{{cart_item.quantity}}</p>
                <button @click="addToCart(cart_item)" class="quantity-btn">+</button>
              </div>
              <p class="price">Ціна: <b>{{ cart_item.price }}</b> грн</p>
            </div>
          </div>

          <button class="remove-btn" @click="removeAllFromCart(cart_item.cart_details_id)">✖</button>
        </div>
      </div>

      <div class="purchase" v-if="cart_items.length > 0">
        <p  class="total-price"><b>РАЗОМ:</b> {{ total_price }} грн</p>
        <button class="purchase-btn" @click="makeOrder">Оформити покупку</button>
      </div>

    </div>

    <div v-else>
      <p class="start">Ви не авторизовані. Будь ласка, увійдіть у свій кабінет для перегляду товарів</p>
      <router-link to="/login" class="login">Увійти</router-link>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import { isUserAuthenticated, getUser } from '@/auth'; 

export default {
  data() {
    return {
      cartMessage: '', 
      cart_items: [],
      total_price: 0 
    };
  },
  computed: {
    isUserAuthenticated() {
      return isUserAuthenticated();
    },
    user() {
      return getUser(); 
    }
  },
  mounted() {
    if (this.isUserAuthenticated && this.user) {
      this.checkCart(this.user.id);
    }
  },
  methods: {
    checkCart(userId) {
      axios.get(`http://localhost/Book-Store/database/getCart.php?user_id=${userId}`)
        .then(response => {
          if (response.data && response.data.cart_items) {
            this.cart_items = response.data.cart_items;
            this.total_price = response.data.total_price;
            if (this.cart_items.length === 0) {
              this.cartMessage = 'У вас немає доданих книг';
            } else {
              this.cartMessage = `Додані книги до кошика: ${this.cart_items.length}`;
            }
          } else {
            this.cartMessage = 'У вас немає доданих книг';
          }
        })
        .catch(error => {
          console.error('Помилка запиту:', error);
          this.cartMessage = 'Помилка отримання даних';                              
        });                                                                         
    },
    removeFromCart(cartId) {
      axios.post(`http://localhost/Book-Store/database/removeFromCart.php?cart_details_id=${cartId}`)
        .then(response => {
        const indexToRemove = this.cart_items.findIndex(item => item.cart_details_id === cartId);
        if (indexToRemove !== -1) {
          this.cart_items.splice(indexToRemove, 1);
        }
          this.checkCart(this.user.id);
          console.log(response.data.message);
        })
        .catch(error => {
          console.error('Помилка видалення:', error);
        });
    },
  removeAllFromCart(cartId) {
      axios.post(`http://localhost/Book-Store/database/removeAllFromCart.php?cart_details_id=${cartId}`)
        .then(response => {
        const indexToRemove = this.cart_items.findIndex(item => item.cart_details_id === cartId);
        if (indexToRemove !== -1) {
          this.cart_items.splice(indexToRemove, 1);
        }
          this.checkCart(this.user.id);
          console.log(response.data.message);
        })
        .catch(error => {
          console.error('Помилка видалення:', error);
        });
    },
    addToCart(cartItem) {
      axios.post('http://localhost/Book-Store/database/addToCart.php', {
        user_id: this.user.id,
        book_id: cartItem.book_id,
        price: cartItem.price
      })
      .then(response => {
        this.checkCart(this.user.id); 
        console.log(response.data.message);
      })
      .catch(error => {
        console.error('Помилка оновлення кількості:', error);
      });
    },
    makeOrder(){
    const cartItemsString = encodeURIComponent(JSON.stringify(this.cart_items));
    const totalPrice = this.total_price;
    this.$router.push({ path: '/order', query: { cartItems: cartItemsString, totalPrice } });
  }
  }
};
</script>

<style scoped>
.start {
  color: #666;
  font-size: 22px;
}

.login {
  padding: 10px 20px;
  background-color: #ec70a8;
  color: #fff;
  border-radius: 5px;
  border-style: none;
  cursor: pointer;
  transition: background-color 0.5s;
  font-size: 22px;
  text-decoration: none;
}

.login:hover {
  background-color: #cb4d86;
}

.cart {
  display: flex;
  flex-direction: column;
  width: 1000px;
  margin: 0 auto;
  margin-bottom: 100px;
}

.book-info {
  display: flex;
  justify-content: space-between;
  padding: 10px;
  border: 1px solid #ddd;
}

.book-details {
  display: flex;
}

.book-cover {
  width: 200px;
  height: 300px;
  margin-right: 20px;
  border-radius: 10px;
}

.details {
  text-align: left;
}

.number {
  font-size: 22px;
  margin: 10px;
}

.name {
  font-weight: lighter;
  font-size: 22px;
  margin-bottom: -20px;
  color: #333;
}

.name:hover {
  color: #ec70a8;
}

.author {
  color: rgb(59, 81, 126); 
  font-weight: lighter;
  font-size: 20px;
}

.quantity {
  margin-top:40px;
  font-size: 20px;
  display:flex;
  align-items: center; 
}
.quantity-text{
  margin:0px 15px 0px 15px;
}
.quantity-btn{
  width:30px;
  height:30px;
  border:1px solid #ddd;
  background-color: none;
}
.quantity-btn:hover{
  background-color: #ddd;
}

.price {
  text-align: left;
  color: rgb(135, 24, 24);
  font-size: 20px;  
  margin-top: 100px;
}

.remove-btn {
  box-shadow: 0px 4px 8px 2px rgba(0, 0, 0, 0.2);
  border: none;
  color: rgb(135, 24, 24);
  font-size: 20px;
  cursor: pointer;
  align-self: flex-start;
  margin-left: 20px;
}

.remove-btn:hover {
  background-color: #ddd;
}

.total-price {
  display: inline-block;
  color: rgb(209, 43, 43);
  font-size: 22px;
  padding: 10px;
  border-top: 1px solid #666;
}
.purchase{
  margin-top:50px;
  display: flex;
  justify-content: space-between;
  align-items: center; 
}
.purchase-btn {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: #fff;
  border-radius: 5px;
  border-style: none;
  cursor: pointer;
  transition: background-color 0.5s;
  font-size: 22px;
}

.purchase-btn:hover {
  background-color: #2e7531;
}
</style>
