<template>
  <q-input
    v-model="model"
    :label="label"
    :rules="rules"
    :type="type"
    :mask="mask"
    hide-bottom-space
  />
</template>

<script setup lang="ts">
import { ValidationRule } from 'quasar';
import { defineProps } from 'vue';

interface Props {
  label: string;
  rules: ValidationRule[];
  type?: 'text' | 'date' | 'email';
  mask?: string;
}

const model = defineModel<string>();

const {type = 'text'} = defineProps<Props>();

</script>