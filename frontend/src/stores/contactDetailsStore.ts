import { defineStore } from 'pinia';
import { ContactDetails } from 'src/types/models';
import { ref } from 'vue';

export const useContactDetailsStore = defineStore('contactDetails', () => {
  const currentContactDetails = ref<ContactDetails>({
    phoneNumber: '',
    emailAddress: '',
  });
  
  return {
    currentContactDetails,
  }
});