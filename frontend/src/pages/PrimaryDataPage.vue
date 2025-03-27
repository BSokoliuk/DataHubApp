<template>
  <q-page class="row items-center justify-center">
    <PrimaryDataForm />
  </q-page>
</template>

<script setup lang="ts">
import PrimaryDataForm from 'components/PrimaryDataForm.vue';
import { SessionStorageManager } from 'src/utils/SessionStorageManager';
import { onMounted, onUnmounted } from 'vue';

const sessionStorageManager = new SessionStorageManager();

onMounted(() => {
  window.addEventListener('beforeunload', sessionStorageManager.cacheInSessionStorage);
  sessionStorageManager.retrieveSessionData();
});

onUnmounted(() => {
  window.removeEventListener('beforeunload', sessionStorageManager.cacheInSessionStorage);
});

defineOptions({
  name: 'IndexPage'
});
</script>
