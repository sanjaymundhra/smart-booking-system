<template>
  <div class="mt-6 bg-white shadow p-5 rounded border">

    <h2 class="text-xl font-semibold mb-4">Confirm Your Booking</h2>

    <div class="space-y-3">

      <div>
        <label class="font-semibold">Email:</label>
        <input
          type="email"
          v-model="email"
          class="border p-2 w-full rounded"
          required
        />
        <p v-if="bookingStore.errors && bookingStore.errors.email" class="text-red-600 text-sm mt-1">
          {{ bookingStore.errors.email[0] }}
        </p>
      </div>

      <div>
        <label class="font-semibold">Full Name:</label>
        <input
          type="text"
          v-model="name"
          class="border p-2 w-full rounded"
        />
      </div>

      <div>
        <label class="font-semibold">Notes:</label>
        <input
          type="text"
          v-model="notes"
          class="border p-2 w-full rounded"
        />
      </div>

      <button
        @click="submit"
        class="w-full bg-green-600 text-white py-2 mt-2 rounded hover:bg-green-700 transition"
      >
        Book Appointment — {{ slot }}
      </button>
    </div>

    <p v-if="bookingStore.formMessage" class="mt-3 text-center">
      {{ bookingStore.formMessage }}
    </p>
  </div>
</template>

<script>
import { useBookingStore } from "../stores/bookingStore";

export default {
  props: {
    slot: String,
    date: String,
    serviceId: Number
  },

  setup() {
    const bookingStore = useBookingStore();
    return { bookingStore };
  },

  data() {
    return {
      email: "",
      name: "",
      notes: ""
    };
  },

  methods: {
    async submit() {
      const ok = await this.bookingStore.bookAppointment({
        email: this.email,
        name: this.name,
        notes: this.notes,
        start_time: this.slot,
        date: this.date,
        service_id: this.serviceId,
      });

      if (ok) {
        this.$emit("booking-done", this.bookingStore.formMessage);
      }
    }
  }
};
</script>
