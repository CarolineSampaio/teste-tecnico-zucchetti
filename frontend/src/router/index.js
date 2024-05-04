import { createRouter, createWebHistory } from 'vue-router'
import CustomersList from '../views/CustomersList.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'list customers',
      component: CustomersList
    }
  ]
})

export default router
