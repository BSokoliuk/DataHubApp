<template>
  <q-page class="row items-center justify-center">
    <div class="form">
      <div class="flex justify-between">
        <div style="display: inline;">
          <span class="form-title">Step 3</span><span>/3</span>
        </div>
        <q-btn
          label="Add Work Experience"
          color="primary"
          flat
          class="q-mb-md"
          @click="addRow"
          icon="add"
        />
      </div>
      <q-table
        flat
        dense
        :rows="store.currentWorkExperienceList"
        :columns="columns"
        row-key="id"
        class="q-mb-md"
        no-data-label="No work experience added"
      >
        <template v-slot:body-cell="props">
          <q-td v-if="props.col.name === 'company'">
            <q-input
              v-model="props.row.company"
              dense
              outlined
              :rules="[validateCompanyName]"
              placeholder="Company"
              hide-bottom-space
            />
          </q-td>
          <q-td v-else-if="props.col.name === 'position'">
            <q-input
              v-model="props.row.position"
              dense
              outlined
              :rules="[validatePosition]"
              placeholder="Position"
              hide-bottom-space
            />
          </q-td>
          <q-td v-else-if="props.col.name === 'dateFrom'">
            <q-input
              v-model="props.row.dateFrom"
              dense
              outlined
              type="date"
              :rules="[
                validateDateFrom,
                () => validateDates(props.row.dateFrom, props.row.dateTo)
              ]"
              hide-bottom-space
            />
          </q-td>
          <q-td v-else-if="props.col.name === 'dateTo'">
            <q-input
              v-model="props.row.dateTo"
              dense
              outlined
              type="date"
              :rules="[
                validateDateTo,
                () => validateDates(props.row.dateFrom, props.row.dateTo)
              ]"
              hide-bottom-space
            />
          </q-td>
          <q-td v-else-if="props.col.name === 'actions'">
            <q-btn
              icon="delete"
              color="negative"
              flat
              dense
              @click="removeRow(props.row.id)"
            />
          </q-td>
        </template>
      </q-table>
      <div class="flex justify-between">
        <q-btn
          label="Back"
          color="grey-5"
          text-color="grey-9"
          @click="goBack"
        />
        <q-btn
          label="Submit"
          color="primary"
          :disable="!isFormValid"
          @click="onSubmit"
        >
          <q-tooltip v-if="!isFormValid" anchor="top middle" style="font-size: 12px;">
            Please fill in all fields with valid data to proceed
          </q-tooltip>
        </q-btn>
      </div>
    </div>
  </q-page>
</template>

<script setup lang="ts">
import { useWorkExperienceStore } from 'src/stores/workExperienceStore';
import { computed, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import { v4 as generateUniqueId } from 'uuid';
import { Notify } from 'quasar';
import { usePrimaryDataStore } from 'src/stores/primaryDataStore';
import { useContactDetailsStore } from 'src/stores/contactDetailsStore';
import { api } from 'boot/axios';
import { SessionStorageManager } from 'src/utils/SessionStorageManager';
import { Payload } from 'src/types/requests';
import { Validator } from 'src/utils/Validator';

const router = useRouter();

const store = useWorkExperienceStore();
const primaryDataStore = usePrimaryDataStore();
const contactDetailsStore = useContactDetailsStore();

const sessionStorageManager = new SessionStorageManager();

onMounted(() => {
  window.addEventListener('beforeunload', sessionStorageManager.cacheInSessionStorage);
  sessionStorageManager.retrieveSessionData();
});

onUnmounted(() => {
  window.removeEventListener('beforeunload', sessionStorageManager.cacheInSessionStorage);
});

const minDate = new Date(new Date().setFullYear(new Date().getFullYear() - 100))
  .toISOString()
  .split('T')[0];
const maxDate = new Date().toISOString().split('T')[0];

const validateCompanyName = Validator.required('Company');
const validatePosition = Validator.required('Position');
const validateDateFrom = Validator.dateRange(minDate, maxDate);
const validateDateTo = Validator.dateRange(minDate, maxDate);
const validateDates = Validator.dateOrder;

type TableColumn = {
  name: string;
  label: string;
  align: 'left' | 'right' | 'center';
  field: string;
}

const columns: TableColumn[] = [
  { name: 'company', label: 'Company', align: 'left', field: 'company' },
  { name: 'position', label: 'Position', align: 'left', field: 'position' },
  { name: 'dateFrom', label: 'Date From', align: 'left', field: 'dateFrom' },
  { name: 'dateTo', label: 'Date To', align: 'left', field: 'dateTo' },
  { name: 'actions', label: 'Actions', align: 'center', field: 'actions' },
];

function addRow() {
  store.currentWorkExperienceList.push({
    uniqueKey: generateUniqueId(),
    company: '',
    position: '',
    dateFrom: '',
    dateTo: '',
  });
}

function removeRow(id: string) {
  store.currentWorkExperienceList = store.currentWorkExperienceList.filter((row) => row.uniqueKey !== id);
}

const isFormValid = computed(() =>
  store.currentWorkExperienceList.every((row) => {
    const companyValid = validateCompanyName(row.company) === true;
    const positionValid = validatePosition(row.position) === true;
    const dateFromValid = validateDateFrom(row.dateFrom) === true;
    const dateToValid = validateDateTo(row.dateTo) === true;
    const dateOrderValid = validateDates(row.dateFrom, row.dateTo) === true;
      
    return (
      companyValid &&
      positionValid &&
      dateFromValid &&
      dateToValid &&
      dateOrderValid
    );
  })
);

function goBack() {
  router.push('/contact-details');
}

async function onSubmit() {
  const payload: Payload = {
    primaryData: primaryDataStore.currentPrimaryData,
    contactDetails: contactDetailsStore.currentContactDetails,
    workExperience: store.currentWorkExperienceList,
  };

  try {
    const response = await api.post('api/submit-data', payload);
    if (response.status === 200) {
      const id = response.data.id;
      Notify.create({
        color: 'positive',
        position: 'top',
        message: response.data.message,
        icon: 'check',
        actions: [{ label: 'Close', color: 'white' }],
        timeout: 5000,
      });
      router.push(`/summary/${id}`);
    }
  } catch (error) {
    console.error(error);
    Notify.create({
      color: 'negative',
      position: 'top',
      message: 'An error occurred. Please try again later',
      icon: 'report_problem',
      actions: [{ label: 'Close', color: 'white' }],
      timeout: 5000,
    })
  }
}
</script>

<style lang="scss" scoped>
.form {
  width: 100%;
  max-width: 700px;
  background: $bg-color;
  padding: 16px;
  margin: 16px auto;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.form-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 16px;
}
</style>