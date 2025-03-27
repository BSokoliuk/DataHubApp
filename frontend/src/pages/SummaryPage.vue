<template>
  <q-page class="row items-center justify-center">
    <template v-if="finishedFetching">
      <div v-if="summary" class="form q-pa-md">
        <h4 class="q-mb-md q-mt-none text-center">Summary</h4>


        <q-card class="q-mb-md">
          <q-card-section>
            <h5 class="q-my-sm text-center">Primary Data</h5>
            <p><strong>First Name:</strong> {{ summary.primaryData?.firstName }}</p>
            <p><strong>Last Name:</strong> {{ summary.primaryData?.lastName }}</p>
            <p><strong>Birth Date:</strong> {{ summary.primaryData?.birthDate }}</p>
          </q-card-section>
        </q-card>
      
        <q-card class="q-mb-md">
          <q-card-section>
            <h5 class="q-my-sm text-center">Contact Details</h5>
            <p><strong>Phone Number:</strong> {{ summary.contactDetails?.phoneNumber }}</p>
            <p><strong>Email Address:</strong> {{ summary.contactDetails?.emailAddress }}</p>
          </q-card-section>
        </q-card>

        <q-card class="q-mb-md">
          <q-card-section>
            <h5 class="q-my-sm text-center">Work Experience</h5>
            <div class="work-experience-container">
              <template v-if="!summary.workExperience || summary.workExperience.length === 0">
                <span>No work experience added</span>
              </template>
              <template v-else>
                <ul class="q-pl-lg">
                  <li v-for="(work, index) in summary.workExperience" :key="index">
                    <p><strong>Company:</strong> {{ work.company }}</p>
                    <p><strong>Position:</strong> {{ work.position }}</p>
                    <p><strong>Date From:</strong> {{ work.dateFrom }}</p>
                    <p><strong>Date To:</strong> {{ work.dateTo }}</p>
                    <hr v-if="index < summary.workExperience.length - 1" />
                  </li>
                </ul>
              </template>
            </div>
          </q-card-section>
        </q-card>
      </div>
      <div v-else>
        <span>Failed to fetch summary data / not found</span>
      </div>
    </template>
    <div v-else>
      <q-spinner-gears size="100px" color="primary" />
    </div>
  </q-page>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { api } from 'boot/axios';
import { Response } from 'src/types/requests';

const route = useRoute();
const summary = ref<Response | null>(null);

const finishedFetching = ref(false);

onMounted(async () => {
  await fetchSummary();
});

async function fetchSummary() {
  const id = route.params.id;
  try {
    const response = await api.get<Response>(`/api/summary/${id}`);
    if (response.status != 404) summary.value = response.data;
  } catch (error) {
    console.error('Failed to fetch summary data:', error);
  } finally {
    finishedFetching.value = true;
  }
}
</script>

<style lang="scss" scoped>
.form {
  background: $bg-color;
}

hr {
  border: none;
  border-top: 1px solid #ccc;
  margin: 8px 0;
}

.work-experience-container {
  max-height: 250px;
  overflow-y: auto;
  padding-right: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>