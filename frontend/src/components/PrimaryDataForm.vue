<template>
  <q-form
    class="q-gutter-sm form"
    @submit="onSubmit"
  >
    <div>
      <span class="form-title">Step 1</span><span>/3</span>
    </div>
    <FormInput
      v-model="store.currentPrimaryData.firstName"
      label="First name *"
      :rules="[validateFirstName]"
    />
    <FormInput
      v-model="store.currentPrimaryData.lastName"
      label="Last name *"
      :rules="[validateLastName]"
    />
    <FormInput
      v-model="store.currentPrimaryData.birthDate"
      label="Birthdate *"
      :rules="[validateBirthDate]"
      type="date"
    />

    <div class="flex justify-end">
      <q-btn
        type="submit"
        label="Next"
        color="primary"
        :disable="!isFormValid"
      >
        <q-tooltip v-if="!isFormValid" anchor="top middle" style="font-size: 12px;">
          Please fill in all fields to proceed
        </q-tooltip>
      </q-btn>
    </div>
  </q-form>
</template>

<script setup lang="ts">
import { usePrimaryDataStore } from 'src/stores/primaryDataStore';
import { computed } from 'vue';
import { useRouter } from 'vue-router';
import FormInput from './FormInput.vue';
import { Validator } from 'src/utils/Validator';

const router = useRouter();

const store = usePrimaryDataStore();

const validateFirstName = Validator.required('First name');
const validateLastName = Validator.required('Last name');
const validateBirthDate = Validator.dateRange(
  new Date(new Date().setFullYear(new Date().getFullYear() - 100)).toISOString().split('T')[0],
  new Date().toISOString().split('T')[0]
);

const isFormValid = computed(() => {
  const firstNameValid = validateFirstName(store.currentPrimaryData.firstName) === true;
  const lastNameValid = validateLastName(store.currentPrimaryData.lastName) === true;
  const birthDateValid = validateBirthDate(store.currentPrimaryData.birthDate) === true;

  return firstNameValid && lastNameValid && birthDateValid;
});

function onSubmit() {
  router.push('contact-details');
}
</script>

<style lang="scss" scoped>
.form {
  width: 300px;
  background: $bg-color;
  padding: 16px;
  margin: 16px auto;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.form-title {
  font-size: 24px;
  font-weight: bold;
}

.q-input {
  margin-bottom: 16px;
}
</style>