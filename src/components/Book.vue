<template>
  <div class="container">
    <div class="book-details">
      <img :src="book.img_src" alt="Book Cover" class="book-cover">
      <div class="book-info">
        <h1 class="name">{{ book.name }}</h1>
        <h3 class="author">{{ book.author }}</h3>
        <div class="price-buy">
          <p class="price"><b>{{ book.price }}</b> грн</p>
          <button class="buy-button" @click="buyBook">До кошика</button>
        </div>
      </div>
    </div>

    <div class="description">
      <h2>Опис книги</h2>
      <p>{{ book.description }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { isAuthenticated, getUser } from '@/auth';

export default {
  props: ['id'],
  data() {
    return {
      book: {}
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
    this.fetchBook();
  },
  methods: {
    fetchBook() {
      axios.get(`http://localhost/Book-Store/backend/getBook.php?id=${this.id}`)
        .then(response => {
          this.book = response.data;
        })
        .catch(error => {
          console.error("There was an error!", error);
        });
    },
    buyBook() {
      if (!this.isAuthenticated) {
        alert("Будь ласка, увійдіть у свій акаунт, щоб додати книгу до кошика.");
        return;
      }

      axios.post('http://localhost/Book-Store/backend/addToCart.php', {
        user_id: this.user.id,
        book_id: this.book.id,
        price: this.book.price
      })
      .then(response => {
        console.log(response.data.message);
      })
      .catch(error => {
        console.error("There was an error!", error);
      });
    }
  }
};
</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  margin-top: 20px;
  margin-bottom: 200px;
}

.book-details {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.book-cover {
  width: 350px;
  height: 480px;
  margin-right: 20px;
  border-radius: 10px;
}

.book-info {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.author {
  color: rgb(59, 81, 126); 
  font-weight: lighter;
  font-size: 22px;
  margin-top: 10px;
}

.name {
  font-size: 36px;
  margin-bottom: 0;
  font-weight: lighter;
}

.price-buy {
  display: flex;
  align-items: center;
  margin-top: 20px;
}

.price {
  color: rgb(135, 24, 24);
  font-size: 30px;
  margin-right: 20px;
}

.description {
  margin-top: 20px;
  font-size: 22px;
  line-height: 1.5;
  width: 1200px;
  text-align: justify;
}

h2 {
  color: rgb(122, 30, 30);
  border-bottom: 1px solid rgb(122, 30, 30);
  font-size: 30px;
  width: 1200px;
  font-weight: lighter;
}

.buy-button {
  padding: 10px 20px;
  background-color: rgb(122, 30, 30);
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 18px;
  transition: background-color 0.3s;
}

.buy-button:hover {
  background-color: rgb(74, 17, 17);
}
</style>
