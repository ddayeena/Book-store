<template>
  <div id="app">
    <component :is="layout">
      <router-view></router-view>
    </component>
  </div>
</template>

<script>
import DefaultLayout from './components/DefaultLayout.vue'; // ваш поточний макет
import FullPage from './components/FullPage.vue'; // новий макет

export default {
  name: 'App',
  computed: {
    layout() {
      return this.$route.meta.layout === 'full-page' ? FullPage : DefaultLayout;
    }
  }
};
</script>
