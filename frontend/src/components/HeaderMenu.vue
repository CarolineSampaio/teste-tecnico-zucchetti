<template>
  <header>
    <div class="menu">
      <img src="@/assets/logo-clip.png" alt="logo linha clipp" />
      <nav>
        <router-link to="/">Home</router-link>
        <router-link to="/customers">Customers</router-link>
        <router-link to="/payments">Payments Method</router-link>
        <router-link to="/products">Products</router-link>
        <router-link to="/orders">Orders</router-link>
      </nav>
    </div>
  </header>
</template>

<script>
export default {
  name: 'HeaderMenu'
}
</script>

<style scoped>
header {
  height: 80px;
  background-color: #036ab0;
  margin: 0 -6% !important;
}

img {
  margin: 0 8%;
  padding: 5px;
  height: 80px;
}

.menu {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

nav {
  display: flex;
  gap: 20px;
  margin: 0 8%;
}

nav a {
  color: white;
  text-decoration: none;
  font-size: 1.2rem;
  font-weight: bold;
  padding: 5px 10px;
}

nav a:hover {
  background-color: white;
  color: #036ab0;
  padding: 5px 10px;
  border-radius: 5px;
}
</style>
