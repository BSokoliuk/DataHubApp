<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-toolbar-title>
          DataHub App
        </q-toolbar-title>
      </q-toolbar>
    </q-header>


    <q-page-container>
      <router-view />
    </q-page-container>
    <q-footer app-inset>
    <q-toolbar>
      <q-toolbar-title>
        © {{ new Date().getFullYear() }} Created by Bohdan Sokoliuk
      </q-toolbar-title>
    </q-toolbar>
  </q-footer>
  </q-layout>
 
</template>

<script setup lang="ts">
defineOptions({
  name: 'MainLayout'
});
</script>
