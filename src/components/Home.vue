<template>
 <h1>ГОЛОВНА</h1>
 <p class="start">Завітайте до нашого магазину та придбайте чудові та якісні книги!</p>
 <img src="\src\assets\home_1.jpg" alt="photo book-store" class="start_img">
 <div class="novelty">
 <h2 class="novelty_start">Останні новинки нашого магазину з яскравим та захоплюючим сюжетом!</h2>
  <router-link to="/novelty">
    <p class="to_novelty">Переходьте на вкладку Новинки та дізнавайтесь про більше книг!</p>
  </router-link>

  <div class="carousel-container"> 

    <button class="scroll-button left" @click="scrollLeft">←</button>

    <div class="carousel-wrapper">
      <div class="carousel">
        <div class="carousel-item" v-for="book in visibleBooks" :key="book.id">
          <router-link :to="{ name: 'Book', params: { id: book.id }}">
            <img :src="book.img_src" alt="Book Cover" class="book-cover">
          </router-link>
          <div class="book-info">
              <router-link :to="{ name: 'Book', params: { id: book.id }}">
                <p class = "name">{{ book.name }}</p>
              </router-link>
            <p class = "author">{{ book.author }}</p>
            <p  class = "price"><b>{{ book.price }}</b> грн</p>
          </div>
        </div>
      </div>
    </div>
    
    <button class="scroll-button right" @click="scrollRight">→</button>
  </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      books: [],
      currentIndex: 0,
      visibleBooks: []
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
          this.updateVisibleBooks();
        })
        .catch(error => {
          console.error("There was an error!", error);
        });
    },
    updateVisibleBooks() {
      this.visibleBooks = this.books.slice(this.currentIndex, this.currentIndex + 3);
    },
    scrollLeft() {
      if (this.currentIndex > 0) {
        this.currentIndex--;
        this.updateVisibleBooks();
      }
    },
    scrollRight() {
      if (this.currentIndex + 3 < this.books.length) {
        this.currentIndex++;
        this.updateVisibleBooks();
      }
    }
  }
}
</script>

<style scoped>
.start_img{
  border-radius:10px;
  width:1200px;
}
.carousel-container {
  display: flex;
  align-items: center;
}

.carousel-wrapper {
  flex-grow: 1;
  display: flex;
  justify-content: center;
}

.carousel {
  display: flex;
  padding:50px;
  border:1px dotted #999;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.5);
}

.carousel-item {
  padding: 10px;
  box-sizing: border-box;
}

.carousel-item img {
    width:300px;
  height:400px;
}

.scroll-button {
  width: 50px;
  height: 50px;
  font-size: 24px;
  cursor: pointer;
  position: absolute;
  top: 50%;
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
}

.left {
  left:0;
  margin-left: 500px;
  margin-top: 1000px;
}

.right {
  right:0;
  margin-right: 500px;
  margin-top: 1000px;
}

.start{
  color: #666;
  font-size: 22px;
}

.novelty_start{
  margin-top:200px;
  margin-bottom:-10px;
  font-size: 28px;
  font-weight: lighter;
}

.book-cover {
  width: 250px;
  height:350px;
  margin-bottom: -10px;
  border-radius:10px;
  transition: transform 0.2s ease;
}
.book-cover:hover{
  transform: scale(1.1);
}
.name {
  color: rgb(59, 81, 126);
  font-size: 24px;
  font-weight:bold;
  text-decoration: none;
}

a {
  text-decoration: none;
}

.name:hover,.to_novelty:hover{
  color:#ec70a8;
  font-size:24px;
  
}
.price{
  color: rgb(173, 28, 28);
  font-size: 28px;
  background: rgb(235, 228, 228);
  border-radius:5px;
}

.author{
  color:#333;
  font-weight:bold;
  font-size:20px;
  margin:-15px;
}  

.to_novelty{
  color: #666;
  font-size: 22px;
  text-decoration: underline;
  display:inline-block;
  transition: font-size 0.1s ease; 
}

.novelty{
  margin-bottom: 300px;
}

h1{
  color:#333;
}

</style>
