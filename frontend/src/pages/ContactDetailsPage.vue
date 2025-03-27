<template>
  <q-page class="row items-center justify-center">
    <ContactDetailsForm />
  </q-page>
</template>

<script setup lang="ts">
import ContactDetailsForm from 'components/ContactDetailsForm.vue';
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
  name: 'ContactDetailsPage'
});

</script>
