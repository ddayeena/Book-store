<template>
<div class="catalog-container">
  <div v-if="isAdminAuthenticated">

    <div  v-if="admin.role === 'admin'" class="catalog">
      <h1>КНИГИ</h1>
      <div class="add-book-container">
        <button class="add-book-btn" @click="addBook">Додати нову книгу</button>
      </div>

      <div class="filter-container">
        <label for="genre-filter">Фільтр за жанром:</label>
        <select id="genre-filter" v-model="selectedGenre">
          <option value="">Усі жанри</option>
          <option value="Детективи">Детективи</option>
          <option value="Трилери та жахи">Трилери та жахи</option>
          <option value="Фентезі">Фентезі</option>
          <option value="Романтична проза">Романтична проза</option>
          <option value="Комікси">Комікси та манга</option>
        </select>
      </div>
      
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

          <div class="btn-container">
            <button class="remove-btn" @click="confirmRemove(book.id)">Видалити книгу</button>
            <button class="change-btn" @click="openEditModal(book)">Редагувати книгу</button>
          </div>

        </div>

      </div>
    </div>

      <div v-else>
        <div class="no-access">
          <h3>КНИГИ</h3>
          <p>⛔</p>
          <p> У вас немає доступу до цієї сторінки. Будь ласка, зв'яжіться з адміном для надання доступу.</p>
        </div>
      </div>
  </div>
  
  <div v-else class="login">
    <h1>КНИГИ</h1>
    <p class="start">Ви не авторизовані. Будь ласка, увійдіть у свій кабінет.</p>
    <router-link to="/log-admin" class="login-button">Увійти</router-link>
  </div>

  <div v-if="showEditModal" class="modal">
    <div class="modal-content">
      <span class="close" @click="closeEditModal">&times;</span>
      <h2>Редагувати книгу</h2>

      <form @submit.prevent="updateBook">
        <div class="form-group">
          <label for="edit-name">Назва:</label>
          <input type="text" id="edit-name" v-model="editedBook.name" required>
        </div>

        <div class="form-group">
          <label for="edit-author">Автор:</label>
          <input type="text" id="edit-author" v-model="editedBook.author" required>
        </div>

        <div class="form-group">
          <label for="edit-description">Опис:</label>
          <textarea id="edit-description" v-model="editedBook.description" required></textarea>
        </div>

        <div class="form-group">
          <label for="edit-price">Ціна:</label>
          <input type="number" id="edit-price" v-model="editedBook.price" required>
        </div>

        <div class="form-group">
          <label for="edit-genre">Жанр:</label>
          <select id="edit-genre" v-model="editedBook.genre_name" required>
            <option value="Детективи">Детективи</option>
            <option value="Трилери та жахи">Трилери та жахи</option>
            <option value="Фентезі">Фентезі</option>
            <option value="Романтична проза">Романтична проза</option>
            <option value="Комікси та манга">Комікси та манга</option>
          </select>
        </div>

        <div class="form-group">
          <label for="edit-is_new">Новинка:</label>
          <input type="checkbox" id="edit-is_new" v-model="editedBook.is_new">
        </div>

        <button type="submit" class="btn">Підтвердити зміни</button>
      </form>

    </div>
  </div>

</div>
</template>

<script>
import axios from 'axios';
import { isAdminAuthenticated,getAdmin } from '@/auth.js';

export default {
  data() {
    return {
      books: [],
      searchQuery: '',
      selectedGenre: '',
      showEditModal: false,
      editedBook: {}
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
    addBook() {
      this.$router.push('/add-book');
    },
    confirmRemove(bookId) {
      if (confirm("Ви впевнені, що хочете видалити цю книгу?")) {
        this.removeBook(bookId);
      }
    },
    removeBook(bookId) {
      axios.post('http://localhost/Book-Store/database/removeBook.php', { id: bookId })
        .then(response => {
          alert("Книга видалена");
          this.fetchBooks(); 
        })
        .catch(error => {
          console.error("There was an error!", error);
        });
    },
    openEditModal(book) {
      this.editedBook = { ...book };
      this.showEditModal = true;
    },
    closeEditModal() {
      this.showEditModal = false;
    },
    updateBook() {
      axios.post('http://localhost/Book-Store/database/updateBook.php', {
        id: this.editedBook.id,
        name: this.editedBook.name,
        author: this.editedBook.author,
        description: this.editedBook.description,
        price: this.editedBook.price,
        genre: this.editedBook.genre_name,
        is_new: this.editedBook.is_new? 1:0
      })
        .then(response => {
          console.log(response.data.message);
          this.fetchBooks();
          this.closeEditModal();
        })
        .catch(error => {
          console.error("There was an error!", error);
        });
    }
  },
  computed: {
    isAdminAuthenticated() {
      return isAdminAuthenticated();
    },
    admin(){
      return getAdmin();
    },
    filteredBooks() {
      let filtered = this.books;

      if (this.selectedGenre) {
        filtered = filtered.filter(book => book.genre_name === this.selectedGenre);
      }

      if (this.searchQuery) {
        const searchQueryLower = this.searchQuery.toLowerCase();
        filtered = filtered.filter(book => {
          const nameMatches = book.name.toLowerCase().includes(searchQueryLower);
          const authorMatches = book.author.toLowerCase().includes(searchQueryLower);
          return nameMatches || authorMatches;
        });
      }

      return filtered;
    }
  }
};
</script>

<style scoped>
@import url('@/assets/css/admin_loginstyle.css');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
.catalog-container {
  text-align: center;
}
.catalog {
  width: 100%;
  margin-bottom: 100px;
  border-radius: 8px;
}
.book-item {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.book-info {
  font-size: 18px;
  text-align: left;
  width:100%;
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

.book-genre {
  text-decoration: underline;
}

.book-description {
  text-align: justify;
}
h1 {
  color: #333;
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

.add-book-container {
  text-align: left;
}
.add-book-btn{
  font-size: 18px;
  padding: 10px;
  color: #333;
  border: none;
  border-radius: 10px;
  margin-bottom: 30px;
  text-decoration: underline;
}

.add-book-btn:hover {
  color: #fff;
  background-color: #ec70a8;
}
.remove-btn,.change-btn {
  font-size: 16px;
  padding: 8px 10px;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  width:100%;
  margin-bottom: 30px;
  text-decoration: underline;
}

.remove-btn:hover,.change-btn:hover {
  background-color: #999;
}

.change-btn {
  background-color: darkslategray;
}
.remove-btn{
  background-color: darkred;
}

.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 500px;
  border-radius: 10px;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-size:22px;
}

.form-group input,
.form-group textarea,
.form-group select {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
  font-size: 18px;
  color:#333;
}

.btn {
  background-color: #ec70a8;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.btn:hover {
  background-color: #cb4d86;
}

</style>
