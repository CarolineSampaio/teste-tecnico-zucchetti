<template>
  <header>
    <div class="menu">
      <img src="@/assets/logo-clip.png" alt="logo linha clipp" @click="redirectToHome" />
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
  name: 'HeaderMenu',

  methods: {
    redirectToHome() {
      window.location.href = '/'
    }
  }
}
</script>

<style scoped>
header {
  height: 80px;
  background-color: #036ab0;
}

img {
  margin: 0 0 0 5%;
  padding: 5px;
  height: 80px;
  cursor: pointer;
}

.menu {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

nav {
  display: flex;
  gap: 20px;
  margin: 0 5% 0 0;
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
