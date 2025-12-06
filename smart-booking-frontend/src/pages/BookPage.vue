<template>
  <div class="p-4 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Book an Appointment</h1>

    <!-- Choose Service -->
    <label class="font-semibold mt-4 block">Choose Service:</label>
    <select
      v-model="serviceStore.selectedServiceId"
      @change="onServiceChange"
      class="border p-2 w-full mb-4"
    >
      <option
        v-for="s in serviceStore.services"
        :key="s.id"
        :value="s.id"
      >
        {{ s.name }} ({{ s.duration_minutes }} min)
      </option>
    </select>

    <label class="font-semibold">Select Date:</label>
    <Calendar
      v-model="bookingStore.date"
      @update:modelValue="onDateChange"
    />

    <SlotGrid
      :slots="bookingStore.slots"
      :selected="bookingStore.selectedSlot"
      :loaded="bookingStore.slotsLoaded"
      @select-slot="onSlotSelect"
    />

    <p
      v-if="bookingStore.successMessage"
      class="mt-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded"
    >
      {{ bookingStore.successMessage }}
    </p>

    <BookingForm
      v-if="bookingStore.selectedSlot"
      :slot="bookingStore.selectedSlot"
      :date="bookingStore.date"
      :serviceId="serviceStore.selectedServiceId"
      @booking-done="bookingDone"
    />
  </div>
</template>

<script>
import { useServiceStore } from "../stores/serviceStore";
import { useBookingStore } from "../stores/bookingStore";

import Calendar from "../components/Calendar.vue";
import SlotGrid from "../components/SlotGrid.vue";
import BookingForm from "../components/BookingForm.vue";

export default {
  components: { Calendar, SlotGrid, BookingForm },

  setup() {
    const serviceStore = useServiceStore();
    const bookingStore = useBookingStore();

    serviceStore.loadServices().then(() => {
      bookingStore.fetchSlots(serviceStore.selectedServiceId);
    });

    return { serviceStore, bookingStore };
  },

  methods: {
    onDateChange() {
      this.bookingStore.resetSuccess();
      this.bookingStore.setDate(this.bookingStore.date);
      this.bookingStore.fetchSlots(this.serviceStore.selectedServiceId);
    },

    onServiceChange() {
      this.bookingStore.resetSuccess();
      this.bookingStore.fetchSlots(this.serviceStore.selectedServiceId);
    },

    onSlotSelect(slot) {
      this.bookingStore.resetSuccess(); 
      this.bookingStore.selectSlot(slot);
    },

    bookingDone(message) {
      this.bookingStore.bookingSuccess(message);
      this.bookingStore.fetchSlots(this.serviceStore.selectedServiceId);
    }
  }
};
</script>
