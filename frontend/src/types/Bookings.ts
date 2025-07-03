export interface TimeSlot {
  employeeId: number
  employeeName: string
  startDate: string
  startTime: string
  endDate: string
  endTime: string
}

export interface Filters {
  vet: number
  date: string
  startTime: string
  endTime: string
}
