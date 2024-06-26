<template>
  <div class="users-container">
    <div v-if="isAdminAuthenticated">
      <div class="users" v-if="admin.role === 'admin'">
        <h1>КОРИСТУВАЧІ</h1>

        <div class="filter-container">
          <label for="role-filter">Обрати роль користувача:</label>
          <select v-model="selectedRole" class="role-filter">
            <option value="">Всі ролі</option>
            <option value="admin">Admin</option>
            <option value="registered">Registered</option>
          </select>
        </div>
        
        <div class="search-container">
          <i class="fa fa-search search-icon"></i>
          <input type="text" v-model="searchQuery" placeholder="Пошук користувача за іменем" class="search-bar">

        </div> 

        <div v-if="filteredUsers.length === 0" class="search-text">Не знайдено користувачів за запитом «{{ searchQuery }}»</div>

        <div v-else class="user-item-container">
          <div v-for="(user, index) in filteredUsers" :key="index">
            <div v-if="user.id != admin.id" class="user-item">
              <div class="user-info">
                  <h3 class="user-name">{{ user.name }}</h3>
                  <p class="user-email">Email: {{ user.email }}</p>
                  <p class="user-role">Роль: {{ user.role }}</p>
              </div>
              
              <div class="btn-container">
                  <button v-if="user.role === 'admin'" class="remove-btn" @click="removeRole(user.id)">Зняти роль адміна</button>
                  <button v-if="user.role === 'registered'" class="grant-btn" @click="grantRole(user.id)">Надати роль адміна</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else>
        <div class="no-access">
          <h3>КОРИСТУВАЧІ</h3>
          <p>⛔</p>
          <p> У вас немає доступу до цієї сторінки. Будь ласка, зв'яжіться з адміном для надання доступу.</p>
        </div>
      </div>
    </div>
    
    <div v-else class="login">
      <h1>КОРИСТУВАЧІ</h1>
      <p class="start">Ви не авторизовані. Будь ласка, увійдіть у свій кабінет.</p>
      <router-link to="/log-admin" class="login-button">Увійти</router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { isAdminAuthenticated, getAdmin } from '@/auth.js';

export default {
  data() {
    return {
      users: [],
      searchQuery: '',
      selectedRole: '', // Додано об'єкт для зберігання обраної ролі
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      axios.get('http://localhost/Book-Store/database/getUsers.php')
        .then(response => {
          this.users = response.data;
        })
        .catch(error => {
          console.error("There was an error!", error);
        });
    },
    removeRole(userId) {
      if (confirm("Ви впевнені, що бажаєте зняти роль адміна користувачу?")) {
        axios.post('http://localhost/Book-Store/database/changeUserRole.php', {
          id: userId,
          role: 'registered'
        })
          .then(response => {
            console.log(response.data.message);
            this.fetchUsers();
          })
          .catch(error => {
            console.error("There was an error!", error);
          });
      }
    },
    grantRole(userId) {
      if (confirm("Ви впевнені, що бажаєте надати роль адміна користувачу?")) {
        axios.post('http://localhost/Book-Store/database/changeUserRole.php', {
          id: userId,
          role: 'admin'
        })
          .then(response => {
            console.log(response.data.message);
            this.fetchUsers();
          })
          .catch(error => {
            console.error("There was an error!", error);
          });
      }
    }
  },
  computed: {
    isAdminAuthenticated() {
      return isAdminAuthenticated();
    },
    admin() {
      return getAdmin();
    },
    filteredUsers() {
      if (!this.searchQuery && !this.selectedRole) {
        return this.users;
      }

      const searchQueryLower = this.searchQuery.toLowerCase();
      return this.users.filter(user => {
        const nameMatches = user.name.toLowerCase().includes(searchQueryLower);
        const roleMatches = !this.selectedRole || user.role === this.selectedRole;
        return nameMatches && roleMatches;
      });
    }
  }
};
</script>

<style scoped>
@import url('@/assets/css/admin_loginstyle.css');
.users-container {
  text-align: center;
}
.users {
  margin-bottom: 100px;
  color: #333;
}

.user-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.user-info {
  font-size: 18px;
  text-align: left;
}

.user-name {
  font-size: 22px;
  font-weight: bold;
  color: #333;
}

.user-email {
  color: rgb(59, 81, 126);
}

.user-role {
  text-decoration: underline;
  color: rgb(173, 28, 28);
}

.remove-btn,
.grant-btn {
  font-size: 16px;
  padding: 8px 10px;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  text-decoration: underline;
}

.remove-btn:hover,
.grant-btn:hover {
  background-color: #999;
}

.grant-btn {
  background-color: darkslategray;
}

.remove-btn {
  background-color: darkred;
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


</style>
