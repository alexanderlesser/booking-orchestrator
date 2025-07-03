<template>
  <div>
    <div class="filters">
      <div>
        <label for="selected-veterinarian">Veterinarian</label>
        <select id="selected-veterinarian" v-model="selectedVet">
          <option v-for="vet in veterinarians" :key="vet.employeeId" :value="vet.employeeId">
            {{ vet.employeeName }}
          </option>
        </select>
      </div>

      <div>
        <label for="selected-date">Date</label>
        <input type="date" max="9999-12-31" v-model="selectedDate" />
      </div>

      <div class="time-container">
        <div class="time-inputs-row">
          <span class="time-range-container">
            <label for="start-time">Start time</label>
            <input id="start-time" type="time" v-model="selectedStartTime" />
          </span>
          <span class="time-range-container">
            <label for="end-time">End time</label>
            <input id="end-time" type="time" v-model="selectedEndTime" />
          </span>
        </div>
      </div>
    </div>

    <div class="btn-wrapper">
      <button
        v-if="hasActiveFilters"
        @click="clearFilters"
        class="btn btn--primary"
        type="button"
      >
        Clear Filters
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Filters, TimeSlot } from '@/types/Bookings'
import { defineEmits, ref, watch, computed } from 'vue'

const { timeSlots } = defineProps<{
  timeSlots: TimeSlot[]
}>()

const emit = defineEmits<{
  (e: 'filter-change', filters: Filters): void
}>()

const selectedVet = ref(0)
const selectedDate = ref('')
const selectedStartTime = ref('')
const selectedEndTime = ref('')

const veterinarians = computed(() => {
  const result: { employeeName: string; employeeId: number }[] = [
    { employeeName: 'All', employeeId: 0 },
  ]
  timeSlots.forEach((slot) => {
    const exist = result.find((vet) => vet.employeeId === slot.employeeId)
    if (!exist) {
      result.push({ employeeName: slot.employeeName, employeeId: slot.employeeId })
    }
  })
  return result
})

const hasActiveFilters = computed(() => {
  return (
    selectedVet.value !== 0 ||
    selectedDate.value !== '' ||
    selectedStartTime.value !== '' ||
    selectedEndTime.value !== ''
  )
})

const clearFilters = () => {
  selectedVet.value = 0
  selectedDate.value = ''
  selectedStartTime.value = ''
  selectedEndTime.value = ''
}

watch([selectedVet, selectedDate, selectedStartTime, selectedEndTime], () => {
  emit('filter-change', {
    vet: selectedVet.value,
    date: selectedDate.value,
    startTime: selectedStartTime.value,
    endTime: selectedEndTime.value,
  })
})
</script>

<style scoped>
.filters {
  display: flex;
  gap: 2rem;
  margin: 2rem 0;
  flex-wrap: wrap;
}

.filters > div:not(.time-container) {
  display: flex;
  flex-direction: column;
  min-width: 180px;
}

label {
  font-size: 1.6rem;
  font-weight: 600;
  margin-bottom: 0.4rem;
  color: #333;
  user-select: none;
}

select,
input[type='date'],
input[type='time'] {
  font-size: 1.5rem;
  padding: 0.5rem 0.75rem;
  border: 1.5px solid #ccc;
  border-radius: 6px;
  transition: border-color 0.3s ease;
  width: 100%;
  box-sizing: border-box;
  font-family: inherit;
  cursor: pointer;
}

select:focus,
input[type='date']:focus,
input[type='time']:focus {
  border-color: #0078d4;
}

.time-container {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  min-width: 100px;
}

.time-range-container {
  display: flex;
  flex-direction: column;
  flex: 1;
}

.time-inputs-row {
  display: flex;
  flex-direction: row;
  gap: 1rem;
}

.btn-wrapper {
  margin-bottom: 2rem;
}

@media (max-width: 768px) {
  .filters {
    flex-direction: column;
  }

  .filters > div,
  .time-container {
    min-width: 100%;
  }

  .time-inputs-row {
    flex-direction: column;
  }
}
</style>
