<template>
  <h1>Home</h1>
  <main class="content">
    <CardButtons
      iconClass="fas fa-user"
      title="Customers"
      description="Manage your store's customers"
      listLink="/customers"
      registerLink="/customer/new"
      buttonLabel="Customers"
    />
    <CardButtons
      iconClass="fas fa-credit-card"
      title="Payment methods"
      description="Manage your store's payment methods"
      listLink="/payments"
      registerLink="/payment/new"
      buttonLabel="Payment methods"
    />
    <CardButtons
      iconClass="fas fa-box"
      title="Products"
      description="Manage your store's products"
      listLink="/products"
      registerLink="/product/new"
      buttonLabel="Products"
    />
    <CardButtons
      iconClass="fas fa-shopping-cart"
      title="Orders"
      description="Manage your store orders"
      listLink="/orders"
      registerLink="/order/new"
      buttonLabel="Orders"
    />
  </main>
</template>

<script>
import CardButtons from '@/components/CardButtons.vue'

export default {
  components: {
    CardButtons
  }
}
</script>

<style scoped>
main {
  display: flex;
  justify-content: space-between;
  margin-top: 100px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}
</style>
