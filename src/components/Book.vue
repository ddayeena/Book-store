<template>
  <div class="container">
    
    <div class="book-details">
      <img :src="book.img_src" alt="Book Cover" class="book-cover">
      <div class="book-info">
        <h1 class="name">{{ book.name }}</h1>
        <h3 class="author">{{ book.author }}</h3>
        <p class="price"><b>{{ book.price }}</b> грн</p>
      </div>
    </div>

    <div class="description">
        <h2>Опис книги</h2>
        <p >{{ book.description }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['id'],
  data() {
    return {
      book: {}
    };
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
  height:480px;
  margin-right: 20px;
  border-radius: 10px;
}

.book-info {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.author{
  color: rgb(59, 81, 126); 
  font-weight:lighter;
  font-size:22px;
  margin-top: 10px;
}
.name{
  font-size:36px;
  margin-bottom: 0;
  font-weight:lighter;
}

.price {
  color: rgb(135, 24, 24);
  font-size: 30px;
  margin-top: 200px;
}

.description {
  margin-top: 20px;
  font-size: 22px;
  line-height: 1.5;
  width: 1200px;
  text-align: justify;
}

h2{
    color:rgb(122, 30, 30);
    border-bottom: 1px solid rgb(118, 27, 27);
    font-size:30px;
    width:1200;
    font-weight:lighter;
}
</style>
