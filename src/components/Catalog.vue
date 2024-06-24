<template>
  <div class="catalog">
    <h1>КАТАЛОГ КНИГ</h1>
    <p class="start">Будь які книги на ваш вибір</p>

    <div class="search-container">
      <i class="fa fa-search search-icon"></i>
      <input type="text" v-model="searchQuery" placeholder="Пошук книги" class="search-bar">
    </div>

    <div v-if="filteredBooks.length === 0" class="search-text">Не знайдено книг за запитом «{{searchQuery}}»</div>

    <div v-else>
      <div class="book-row" v-for="(row, index) in Math.ceil(filteredBooks.length / 4)" :key="index">
        <div class="book" v-for="book in getBooksInRow(index, filteredBooks)" :key="book.id">

          <router-link :to="{ name: 'Book', params: { id: book.id }}">
            <img :src="book.img_src" alt="Book Cover" class="book-cover">
          </router-link>

          <div class="book-info">
            <p class="price"><b>{{ book.price }}</b> грн</p>
            <router-link :to="{ name: 'Book', params: { id: book.id }}">
              <h3 class="name">{{ book.name }}</h3>
            </router-link>
            <p class="author">{{ book.author }}</p>
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
      books: [],
      searchQuery: ''
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
    getBooksInRow(rowIndex, books) {
      const start = rowIndex * 4;
      const end = start + 4;
      return books.slice(start, end);
    }
  },
  computed: {
    filteredBooks() {
      if (!this.searchQuery) {
        return this.books;
      }
      const searchQueryLower = this.searchQuery.toLowerCase();
      return this.books.filter(book => {
        const nameMatches = book.name.toLowerCase().includes(searchQueryLower);
        const authorMatches = book.author.toLowerCase().includes(searchQueryLower);
        return nameMatches || authorMatches;
      });
    }
  }
};
</script>

<style scoped>
@import url('@/assets/css/bookstyle.css');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
</style>
