import { useContactDetailsStore } from 'src/stores/contactDetailsStore';
import { usePrimaryDataStore } from 'src/stores/primaryDataStore';
import { useWorkExperienceStore } from 'src/stores/workExperienceStore';

export class SessionStorageManager {
  private primaryDataStore = usePrimaryDataStore();
  private contactDetailsStore = useContactDetailsStore();
  private workExperienceStore = useWorkExperienceStore();

  cacheInSessionStorage = (): void => {
    sessionStorage.setItem(
      'primaryData',
      JSON.stringify(this.primaryDataStore.currentPrimaryData)
    );
    sessionStorage.setItem(
      'contactDetails',
      JSON.stringify(this.contactDetailsStore.currentContactDetails)
    );
    sessionStorage.setItem(
      'workExperience',
      JSON.stringify(this.workExperienceStore.currentWorkExperienceList)
    );
  }

  retrieveSessionData = (): void => {
    const primaryData = sessionStorage.getItem('primaryData');
    if (primaryData) {
      this.primaryDataStore.currentPrimaryData = JSON.parse(primaryData);
      sessionStorage.removeItem('primaryData');
    }

    const contactDetails = sessionStorage.getItem('contactDetails');
    if (contactDetails) {
      this.contactDetailsStore.currentContactDetails = JSON.parse(contactDetails);
      sessionStorage.removeItem('contactDetails');
    }

    const workExperience = sessionStorage.getItem('workExperience');
    if (workExperience) {
      this.workExperienceStore.currentWorkExperienceList = JSON.parse(workExperience);
      sessionStorage.removeItem('workExperience');
    }
  }
}