<template>
  <q-form
    class="q-gutter-sm form"
    @submit="onSubmit"
  >
    <div>
      <span class="form-title">Step 2</span><span>/3</span>
    </div>
    <FormInput
      v-model="store.currentContactDetails.phoneNumber"
      label="Phone number *"
      :rules="[validatePhoneNumber]"
      mask="+## ### ### ###"
    />
    <FormInput
      v-model="store.currentContactDetails.emailAddress"
      label="Email address *"
      :rules="[validateEmailAddress]"
      type="email"
    />

    <div class="flex justify-between">
      <q-btn
        label="Back"
        color="grey-5"
        text-color="grey-9"
        @click="goBack"
      />
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
import { useContactDetailsStore } from 'src/stores/contactDetailsStore';
import { computed } from 'vue';
import { useRouter } from 'vue-router';
import FormInput from './FormInput.vue';
import { Validator } from 'src/utils/Validator';

const router = useRouter();

const store = useContactDetailsStore();

const validatePhoneNumber = Validator.phoneNumber;
const validateEmailAddress = Validator.email;

const isPhoneNumberValid = computed(() =>
  validatePhoneNumber(store.currentContactDetails.phoneNumber) === true
);
const isEmailAddressValid = computed(() =>
  validateEmailAddress(store.currentContactDetails.emailAddress) === true
);

const isFormValid = computed(() =>
  isPhoneNumberValid.value
  && isEmailAddressValid.value
);

function onSubmit() {
  router.push('/work-experience');
}

function goBack() {
  router.push('/');
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