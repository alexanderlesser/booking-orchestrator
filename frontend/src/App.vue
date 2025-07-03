<template>
  <nav class="navbar">
    <div class="content-container">
      <span class="navbar-title">Book times</span>
    </div>
  </nav>

  <main>
    <div class="content-container">
      <BookingTable />
    </div>
  </main>
</template>

<script setup lang="ts">
import BookingTable from './components/BookingTable.vue'
</script>

<style scoped></style>
