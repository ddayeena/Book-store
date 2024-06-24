import { createWebHashHistory, createRouter } from 'vue-router'

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
import Register from './components/Register.vue'
import LogIn from './components/LogIn.vue'
import Order from './components/order/Order.vue'
import OrderConfirmation from './components/order/OrderConfirmation.vue'
import OrderDetails from './components/order/OrderDetails.vue'

import UsersOrders from './components/admin/UsersOrders.vue'
import LogAdmin from './components/admin/LogAdmin.vue'
import RegAdmin from './components/admin/RegAdmin.vue'
import ManageOrder from './components/admin/ManageOrder.vue'

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
        { path: '/book', name: 'Book',component: Book, props: true},
        { path: '/register', component: Register},
        { path: '/login', component: LogIn},
        { path: '/order', component: Order},
        { path: '/confirmation', component: OrderConfirmation},
        { path: '/order-details' , name:'OrderDetails', component: OrderDetails, props:true},

        { path: '/users-orders', name:'UsersOrders', component: UsersOrders, meta: {layout: 'full-page'}},
        { path: '/admin',name:'LogAdmin', component: LogAdmin,meta: {layout: 'full-page'}},
        { path: '/manage-order', name:'ManageOrder', component: ManageOrder, meta:{layout:'full-page'}},
        { path: '/reg-admin', name:'RegAdmin', component: RegAdmin, meta:{layout:'full-page'}}
    ]
})
