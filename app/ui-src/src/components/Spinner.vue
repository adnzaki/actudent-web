<template>
  <div class="spinner">
    <div class="column items-center">
      <div class="col container">
        <div class="loadingio-spinner-eclipse-mouc9ymcoqs">
          <div class="ldio-0xfrzon96ki">
            <div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.spinner {
  width: 100%;
  position: relative;
  z-index: 999;
}

.container {
  margin-top: 20vh;
}

@media (max-width: 576px) {
  .container {
    margin-top: 5vh;
    margin-bottom: 10vh;
  }
}

@keyframes ldio-0xfrzon96ki {
  0% {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(180deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.ldio-0xfrzon96ki div {
  position: absolute;
  animation: ldio-0xfrzon96ki 0.25s linear infinite;
  width: 80px;
  height: 80px;
  top: 10px;
  left: 10px;
  border-radius: 50%;
  box-shadow: 0 2.7px 0 0 #2196f3;
  transform-origin: 40px 41.35px;
}
.loadingio-spinner-eclipse-mouc9ymcoqs {
  width: 99px;
  height: 99px;
  display: inline-block;
  overflow: hidden;
  background: none;
}
.ldio-0xfrzon96ki {
  width: 100%;
  height: 100%;
  position: relative;
  transform: translateZ(0) scale(0.99);
  backface-visibility: hidden;
  transform-origin: 0 0; /* see note above */
}
.ldio-0xfrzon96ki div {
  box-sizing: content-box;
}
</style>

<script>
export default {
  name: "SpinnerLoading",
  setup() {
    return {};
  },
};
</script>
