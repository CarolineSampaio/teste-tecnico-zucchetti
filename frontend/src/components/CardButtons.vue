<template>
  <div class="card">
    <div class="icon">
      <i :class="iconClass"></i>
    </div>
    <div class="informations">
      <h3>{{ title }}</h3>
      <p>{{ description }}</p>
      <div class="buttons">
        <router-link v-if="listLink" :to="listLink">
          <button>{{ buttonLabel }} List</button>
        </router-link>
        <router-link v-if="registerLink" :to="registerLink">
          <button>New {{ buttonLabel }}</button>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    iconClass: {
      type: String,
      required: true
    },
    title: {
      type: String,
      required: true
    },
    description: {
      type: String,
      default: ''
    },
    listLink: {
      type: String,
      default: ''
    },
    registerLink: {
      type: String,
      default: ''
    },
    buttonLabel: {
      type: String,
      default: 'Clientes'
    }
  }
}
</script>

<style scoped>
.card {
  width: 40vh;
  height: 50vh;
  background-color: #fff;
  border: 1px solid #ccc;
  box-shadow: 0px 0px 15px rgba(27, 111, 170, 0.2);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  margin-bottom: 20px;
}

.icon {
  width: 100%;
  height: 65%;
  display: flex;
  background-color: #ececec;
  justify-content: center;
  align-items: center;
}

.icon i {
  font-size: 4rem;
  color: #155786;
}

.informations {
  display: flex;
  flex-direction: column;
  gap: 5px;
  color: #155786;
  padding: 10px 20px;
}

.buttons {
  display: flex;
  flex-direction: column;
}

button {
  width: 30vh;
  background-color: #036ab0;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background-color: #155786;
}
</style>
