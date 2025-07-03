<template>
  <div class="table-wrapper">
    <h2 class="heading">Available Times</h2>

    <p v-if="loading">Loading...</p>

    <div v-else="!loading">
      <p class="info-text">
        Available times for all veterinarians. Use the filters available to find the time
        you are looking for. Each session last 15 minutes.
      </p>
      <div>
        <TableFilters :time-slots="timeSlots" @filter-change="onFilterChange" />
      </div>
      <table class="booking-table">
        <thead>
          <tr>
            <th>Veterinarian</th>
            <th>Date</th>
            <th>Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <div v-if="errorMessage">
          <p>{{ errorMessage }}</p>
        </div>
        <tbody>
          <tr v-for="(slot, index) in visibleSlots" :key="index">
            <td>{{ slot.employeeName }}</td>
            <td>{{ slot.startDate }}</td>
            <td>{{ slot.startTime.slice(11, 16) }}</td>
            <td>
              <button class="btn btn--secondary book-btn" @click="bookTime(slot)">Book</button>
            </td>
          </tr>
        </tbody>
      </table>
      <div
        class="button-container"
        v-if="filteredSlots.length > rowsVisible && !loading"
      >
        <button @click="rowsVisible += 20" class="btn btn--primary" type="button">Show More</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref, computed } from 'vue'
import type { GetResponse } from '@/types/Response'
import type { Filters, TimeSlot } from '@/types/Bookings'
import TableFilters from '../TableFilters'

const timeSlots = ref<TimeSlot[]>([])
const loading = ref(true)
const rowsVisible = ref(20)
const errorMessage = ref('')
const filters = ref<Filters>({
  vet: 0,
  date: '',
  startTime: '',
  endTime: '',
})

onMounted(async () => {
  try {
    const baseUrl = import.meta.env.VITE_BASE_URL
    const response = await fetch(baseUrl + '/api/slots')

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`)
    }

    const json: GetResponse<TimeSlot[]> = await response.json()
    timeSlots.value = json.data
  } catch (error) {
    console.error('Failed to fetch bookings:', error)
    errorMessage.value = 'Failed to fetch bookings, please try again later.'
  } finally {
    loading.value = false
  }
})

const bookTime = (booking: TimeSlot) => {
  alert(`Booking time for: ${booking.endTime}`)
}

const onFilterChange = (newFilters: typeof filters.value) => {
  filters.value = newFilters
  rowsVisible.value = 20
}

const filteredSlots = computed(() => {
  return timeSlots.value.filter((slot) => {
    // Filter by vet if not "all"
    if (filters.value.vet !== 0 && slot.employeeId !== filters.value.vet) {
      return false
    }

    if (filters.value.date && slot.startDate !== filters.value.date) {
      return false
    }

    // Filter by start time
    if (filters.value.startTime) {
      const slotTime = slot.startTime.slice(11, 16)
      if (slotTime < filters.value.startTime) {
        return false
      }
    }

    // Filter by end time
    if (filters.value.endTime) {
      const slotTime = slot.startTime.slice(11, 16)
      if (slotTime > filters.value.endTime) {
        return false
      }
    }

    return true
  })
})

const visibleSlots = computed(() => filteredSlots.value.slice(0, rowsVisible.value))
</script>

<style scoped>
.table-wrapper {
  overflow-x: auto;
  margin-top: 2rem;
}

.heading {
  margin-bottom: 2rem;
}

.info-text {
  padding: 2rem, 0.5rem;
}

.booking-table {
  width: 100%;
  border-collapse: collapse;
}

.booking-table th,
.booking-table td {
  border: 1px solid var(--color-border);
  font-size: 1.6rem;
  padding: 1rem 1.2rem;
  text-align: left;
  white-space: nowrap;
}

.booking-table tr:hover {
  background-color: #f5f5f5;
}

.button-container {
  margin-top: 1.5rem;
  margin-bottom: 3rem;
}

@media (max-width: 400px) {
  .booking-table th,
  .booking-table td {
    font-size: 1.4rem;
    padding: 0.6rem 0.8rem;
  }
  .book-btn,
  .show-more-btn {
    font-size: 1.4rem;
    padding: 0.6rem 1rem;
  }
}
</style>
