<template>
      <div class="loader-shop">
        <i class="fas fa-shopping-cart"></i>
        <i class="fas fa-spinner"></i>
      </div>
</template>

<script>
export default {
  name: "Loader",
}
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.loader-shop {
  display:flex;
  position:absolute;
  top: 60px;
  background: #2b2b36;;
  width:100vw;
  height:calc(100vh - 60px);
  justify-content: center;
  align-items: center;
  font-size:30px;
  z-index: 1;
  box-shadow:inset 0px 0px 50px 10px #313030;
  color: #a1a0a0;
}

.loader-shop i {
  width: auto;
  height:auto;
}

.loader-shop .fa-spinner {
  position: absolute;
  font-size: 80px;
}

.loader-shop .fa-shopping-cart {
  animation: homeSpin 1s infinite ease-in-out;
}
</style>