import { createRouter, createWebHistory } from 'vue-router'
import CustomersList from '../views/CustomersList.vue'
import CustomersNew from '../views/CustomersNew.vue'
import ProductsList from '../views/ProductsList.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/customers',
      name: 'list customers',
      component: CustomersList
    },
    {
      path: '/customer/new',
      name: 'add customer',
      component: CustomersNew
    },
    {
      path: '/customer/:id/edit',
      name: 'edit customer',
      component: CustomersNew
    },
    {
      path: '/products',
      name: 'list products',
      component: ProductsList
    }
  ]
})

export default router
