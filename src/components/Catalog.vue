<template>
  <div class="catalog">
    <h1>КАТАЛОГ КНИГ</h1>
    <p class = "start">Будь які книги на ваш вибір</p>

    <div v-if="books.length === 0">Завантаження...</div>

    <div v-else>
      <div class="book-row" v-for="(row, index) in Math.ceil(books.length / 4)" :key="index" >
        <div class="book" v-for="book in getBooksInRow(index)" :key="book.id">
          <router-link :to="{ name: 'Book', params: { id: book.id }}">
            <img :src="book.img_src" alt="Book Cover" class="book-cover">
          </router-link>
          <div class="book-info">
            <p  class = "price"><b>{{ book.price }}</b> грн</p>
              <router-link :to="{ name: 'Book', params: { id: book.id }}">
                <h3 class = "name">{{ book.name }}</h3>
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
      axios.get('http://localhost/Book-Store/backend/getBooks.php')
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
};
</script>

<style scoped>
@import url('@/assets/css/bookstyle.css');

</style>
