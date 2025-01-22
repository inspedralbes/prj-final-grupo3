<template>
  <div>

    <navbar />
    <AppHeader />
    <slot />
    <AppFooter />
  </div>
</template>

<script>
import navbar from "~/components/navbar.vue";

export default {
  components: {
    navbar,
  },
};
</script>
