<template>
  <div class="catalog">
    <h1>КНИГИ</h1>
    <button class="add-book-btn" @click="addBook">Додати нову книгу</button>
    <div class="search-container">
      <i class="fa fa-search search-icon"></i>
      <input type="text" v-model="searchQuery" placeholder="Пошук книги" class="search-bar">
    </div>

    <div v-if="filteredBooks.length === 0" class="search-text">Не знайдено книг за запитом «{{searchQuery}}»</div>

    <div v-else>
      <div class="book-item" v-for="(book, index) in filteredBooks" :key="index">
        <p class="number">{{ index + 1 }}</p>
        <img :src="book.img_src" alt="Book Cover" class="book-cover">

        <div class="book-info">
          <h3 class="book-name">{{ book.name }}</h3>
          <p class="book-author">{{ book.author }}</p>
          <p class="book-price"><b>{{ book.price }}</b> грн</p>
          <p class="book-genre"> Жанр: {{book.genre_name}}</p>
          <p class="book-description">{{book.description}}</p>
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
      axios.get('http://localhost/Book-Store/database/getBooks.php')
        .then(response => {
          this.books = response.data;
        })
        .catch(error => {
          console.error("There was an error!", error);
        });
    },
    addBook(){
        this.$router.push('/add-book');
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
.catalog {
  max-width: 1300px;
  margin: 0 auto;
  margin-bottom: 200px;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0px 4px 10px 4px rgba(0,0,0,0.1);
}

.book-item {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.number {
  font-size: 22px;
  margin-right: 20px;
}

.book-cover {
  width: 150px;
  height: 200px;
  margin-right: 50px;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.book-info {
  font-size: 18px;
  text-align: left;
}

.book-name {
  font-size: 22px;
  font-weight: bold;
  color: #333;
}

.book-author {
  font-size: 20px;
  color: rgb(59, 81, 126); 
}

.book-price {
  font-size: 20px;
  color: rgb(173, 28, 28);
}

.book-genre{
  text-decoration:underline;
}
.book-description{
  text-align: justify;
  padding-right:30px ;
}
h1 {
  color: #333;
}

a {
  text-decoration: none;
}

a h3:hover {
  color: #ec70a8;
}

.search-bar {
  margin-bottom: 20px;
  width: 100%;
  box-sizing: border-box;
  font-size: 22px;
  padding: 10px 10px 10px 50px;
}

.search-text {
  font-size: 20px;
  color: brown;
  font-style: italic;
}

.search-container {
  display: flex;
  align-items: center;
  position: relative;
}

.search-icon {
  position: absolute;
  left: 10px;
  margin-bottom: 20px;
  font-size: 28px;
  color: #aaa;
}

.add-book-btn {
  font-size: 18px;
  padding: 10px;
  color: #333;
  border: none;
  border-radius: 10px;
  margin: 10px 0px 20px 0px;
  text-decoration: underline;
}

.add-book-btn:hover {
  color: #fff;
  background-color: #ec70a8;
}

@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
</style>
