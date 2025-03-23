import { defineStore } from 'pinia';
import { PrimaryData } from 'src/types/models';
import { ref } from 'vue';


export const usePrimaryDataStore = defineStore('primaryData', () => {
  const currentPrimaryData = ref<PrimaryData>({
    firstName: '',
    lastName: '',
    birthDate: '',
  });
  
  return {
    currentPrimaryData,
  }
});