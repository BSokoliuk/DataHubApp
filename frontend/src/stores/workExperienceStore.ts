import { defineStore } from 'pinia';
import { WorkExperience } from 'src/types/models';
import { ref } from 'vue';
import { v4 as uuidv4 } from 'uuid';

export const useWorkExperienceStore = defineStore('workExperience', () => {
  const currentWorkExperienceList = ref<WorkExperience[]>([{
    uniqueKey: uuidv4(),
    company: '',
    position: '',
    dateFrom: '',
    dateTo: ''
  }]);
  
  return {
    currentWorkExperienceList,
  }
});