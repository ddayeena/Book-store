<template>
  <div class="catalog">
     <h1>НОВИНКИ</h1>
    <p class="start">Останні новинки нашого магазину з яскравим та захоплюючим сюжетом!</p>

    <div v-if="books.length === 0">Завантаження...</div>

    <div v-else>
      <div class="book-row" v-for="(row, index) in Math.ceil(books.length / 4)" :key="index" >
        <div class="book" v-for="book in getBooksInRow(index)" :key="book.id">
          <p class= "new">NEW!!!</p>
          <router-link :to="{ name: 'Book', params: { id: book.id }}">
            <img :src="book.img_src" alt="Book Cover" class="book-cover">
          </router-link>
          <div class="book-info">
            <p  class = "price"><b>{{ book.price }}</b> грн</p>
              <router-link :to="{ name: 'Book', params: { id: book.id }}">
                <h3 class = "name">{{ book.name }}</h3>
              </router-link>
            <p class = "author">{{ book.author }}</p>
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
      axios.get('http://localhost/Book-Store/backend/getNovelty.php')
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
.new{
    font-size:26px;
    color:#fff;
    font-style:initial;
    background:rgb(173, 28, 28);
    margin-bottom:15px;
    padding:10px;
    border-radius:15px;
}
</style>

