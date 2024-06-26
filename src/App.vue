<template>
  <div id="app">
    <component :is="layout">
      <router-view></router-view>
    </component>
  </div>
</template>

<script>
import DefaultLayout from './components/DefaultLayout.vue'; 
import FullPage from './components/admin/FullPage.vue'; 

export default {
  name: 'App',
  computed: {
    layout() {
      return this.$route.meta.layout === 'full-page' ? FullPage : DefaultLayout;
    }
  }
};
</script>
