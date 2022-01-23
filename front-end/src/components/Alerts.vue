<template>
  <teleport to="#alert-container">

  <div class="alert-box">
    <div :class="alert, {type}">
      {{message}}
    </div>
  </div>

  </teleport>
</template>

<script>
export default {
  name: "Alerts",
  props: ['type','message']
}
</script>

<style scoped>

</style>