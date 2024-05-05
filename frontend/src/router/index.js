import { createRouter, createWebHistory } from 'vue-router'
import CustomersList from '../views/CustomersList.vue'
import CustomersNew from '../views/CustomersNew.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'list customers',
      component: CustomersList
    },
    {
      path: '/customer/new',
      name: 'add customer',
      component: CustomersNew
    }
  ]
})

export default router
