import { createWebHashHistory, createRouter } from 'vue-router'

//import App from './App.vue'
import About from './components/About.vue'
import Home from './components/Home.vue'
import Catalog from './components/Catalog.vue'
import Novelty from './components/Novelty.vue'
import Cart from './components/Cart.vue'
import MyProfile from './components/MyProfile.vue'
import Detective from './components/catalog/Detective.vue'
import LoveNovels from './components/catalog/LoveNovels.vue'
import ThrillersAndHorror from './components/catalog/ThrillersAndHorror.vue'
import Fantasy from './components/catalog/Fantasy.vue'
import Comics from './components/catalog/Comics.vue'
import Book from './components/Book.vue'

export default createRouter({
    history: createWebHashHistory(),
    routes:[
        { path: '/', component: Home },
        { path: '/about', component: About },
        { path: '/catalog', component: Catalog},
        { path: '/novelty', component: Novelty},
        { path: '/cart', component: Cart},
        { path: '/myprofile', component: MyProfile},
        { path: '/catalog/detective', component: Detective},
        { path: '/catalog/love-novels', component: LoveNovels},
        { path: '/catalog/thrillers-and-horror', component: ThrillersAndHorror},
        { path: '/catalog/fantasy', component: Fantasy},
        { path: '/catalog/comics', component: Comics},
        { path: '/book', component: Book},
    ]
})
