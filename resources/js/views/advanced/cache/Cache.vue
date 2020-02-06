<template>
  <div class="card-deck">
    <div class="card">
      <h4 class="card-header text-center">{{ $t('cache.cache') }}</h4>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-auto">
            <button
              class="btn btn-lg btn-outline-primary"
              :title="$t('cache.cache')"
              @click.prevent="clear('cache')"
            >
              <span class="fas fa-trash" :title="$t('cache.cache')"></span>
              {{ $t('cache.cache') }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <h4 class="card-header text-center">{{ $t('cache.sessions') }}</h4>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-auto">
            <button
              class="btn btn-lg btn-outline-primary"
              :title="$t('cache.sessions')"
              @click.prevent="clear('sessions')"
            >
              <span class="fas fa-trash" :title="$t('cache.sessions')"></span>
              {{ $t('cache.sessions') }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <h4 class="card-header text-center">{{ $t('cache.views') }}</h4>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-auto">
            <button
              class="btn btn-lg btn-outline-primary"
              :title="$t('cache.views')"
              @click.prevent="clear('views')"
            >
              <span class="fas fa-trash" :title="$t('cache.views')"></span>
              {{ $t('cache.views') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Cache',

  methods: {
    async clear(type) {
      await this.$http.get(`${this.module}/clear/${type}`);
      this.$toasted.success(this.$t(`${this.module}.msg.cleared`, { path: type }));
    }
  }
};
</script>

<style scoped></style>
