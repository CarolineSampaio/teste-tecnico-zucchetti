<template>
  <HeaderMenu />

  <router-view></router-view>
</template>

<script>
import HeaderMenu from '@/components/HeaderMenu.vue'

export default {
  components: {
    HeaderMenu
  }
}
</script>
