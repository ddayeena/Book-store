<template>
  <div class="add-book-form">
    <h2>ДОДАТИ КНИГУ</h2>
    <form @submit.prevent="addBook">
      <div class="form-group">
        <label for="name">Ім'я книги:</label>
        <input type="text" id="name" v-model="book.name" required>
      </div>

      <div class="form-group">
        <label for="author">Автор:</label>
        <input type="text" id="author" v-model="book.author" required>
      </div>

      <div class="form-group">
        <label for="description">Опис:</label>
        <textarea id="description" v-model="book.description" rows="5" required></textarea>
      </div>

      <div class="form-group">
        <label for="price">Ціна:</label>
        <input type="number" id="price" min="0" v-model.number="book.price" required>
      </div>

      <div class="form-group">
        <label for="genre">Жанр:</label>
        <select id="genre" v-model="book.genre" required>
          <option value="Детективи">Детективи</option>
          <option value="Трилери та жахи">Трилери та жахи</option>
          <option value="Романтична проза">Романтична проза</option>
          <option value="Фентезі">Фентезі</option>
          <option value="Комікси">Комікси</option>
        </select>
      </div>

      <div class="form-group">
        <label for="isNew">Новинка:</label>
        <input type="checkbox" id="isNew" v-model="book.isNew">
      </div>

      <div class="form-group">
        <label for="image">Картинка:</label>
        <input type="file" id="image" ref="fileInput" @change="handleFileUpload" accept="image/*" required>
      </div>

      <button type="submit">Додати книгу</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      book: {
        name: '',
        author: '',
        description: '',
        price: null,
        genre: '',
        isNew: false,
        img_src: ''
      }
    };
  },
  methods: {
    addBook() {
      const formData = new FormData();
      formData.append('name', this.book.name);
      formData.append('author', this.book.author);
      formData.append('description', this.book.description);
      formData.append('price', this.book.price);
      formData.append('genre', this.book.genre);
      formData.append('isNew', this.book.isNew ? 1 : 0);
      formData.append('image', this.$refs.fileInput.files[0]);

      axios.post('http://localhost/Book-Store/database/addBook.php', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(response => {
        alert(response.data.message);
        this.$router.push('/manage-books');
      })
      .catch(error => {
        console.error("There was an error!", error);
      });
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.book.img_src = URL.createObjectURL(file);
      }
    }
  }
};
</script>

<style scoped>
.add-book-form {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f2f2f2;
  border-radius: 8px;
  box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
  color: #333;
  text-align: center;
}

.form-group {
  margin-bottom: 20px;
}
label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
  font-size:18px;
}

input[type="text"],
input[type="number"],
textarea,
select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

input{
  font-size:18px;
}

textarea {
  font-size: 18px;
}

button {
  display: block;
  width: 100%;
  padding: 10px;
  font-size: 18px;
  background-color: #ec70a8;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #cb4d86;
}
</style>
