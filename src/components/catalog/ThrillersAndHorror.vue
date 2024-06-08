<template>
  <div class="catalog">
    <h1>ТРИЛЕРИ ТА ЖАХИ</h1>
    <p class="start">Захоплюючі історії для тих, хто не проти полоскотати свої нерви. 
                    Психологічні, детективні та містичні трилери, хоррор, книги, за якими були зняті найкращі фільми жахів.</p>
    <div v-if="books.length === 0">Завантаження...</div>

    <div v-else>
      <div class="book-row" v-for="(row, index) in Math.ceil(books.length / 4)" :key="index" >
        <div class="book" v-for="book in getBooksInRow(index)" :key="book.id">
          <router-link to="/book">
            <img :src="book.img_src" alt="Book Cover" class="book-cover">
          </router-link>
          <div class="book-info">
            <p  class = "price">{{ book.price }} грн</p>
            <router-link to="/book">
              <h3 class="name">{{ book.name }}</h3>
            </router-link>
            <h4 class = "author">{{ book.author }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';


export default {
  data() {
    return {
      books: []
    };
  },
  created() {
    this.fetchBooks();
  },
  methods: {
    fetchBooks() {
      axios.get('http://localhost/BookStore/backend/getBooksByGenre.php?genre_id=3')
        .then(response => {
          this.books = response.data;
        })
        .catch(error => {
          console.error("There was an error!", error);
        });
    },
    getBooksInRow(rowIndex) {
      const start = rowIndex * 4;
      const end = start + 4;
      return this.books.slice(start, end);
    }
  }
}
</script>

<style scoped>
@import url('@/assets/css/bookstyle.css');
</style>
