import { createRouter, createWebHistory } from 'vue-router'
import CustomersList from '../views/CustomersList.vue'
import CustomersNew from '../views/CustomersNew.vue'
import ProductsList from '../views/ProductsList.vue'
import ProductsNew from '../views/ProductsNew.vue'
import PaymentsList from '../views/PaymentsList.vue'
import PaymentsNew from '../views/PaymentsNew.vue'
import OrdersList from '../views/OrdersList.vue'

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
    },
    {
      path: '/product/new',
      name: 'add product',
      component: ProductsNew
    },
    {
      path: '/product/:id/edit',
      name: 'edit product',
      component: ProductsNew
    },
    {
      path: '/payments',
      name: 'list payments methods',
      component: PaymentsList
    },
    {
      path: '/payment/new',
      name: 'add payment method',
      component: PaymentsNew
    },
    {
      path: '/payment/:id/edit',
      name: 'edit payment method',
      component: PaymentsNew
    },
    {
      path: '/orders',
      name: 'list orders',
      component: OrdersList
    }
  ]
})

export default router
