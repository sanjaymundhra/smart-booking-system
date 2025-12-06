<template>
  <div class="p-4 max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold mb-4">All Bookings</h1>

    <p v-if="loading" class="text-gray-600">Loading bookings...</p>

    <p v-if="!loading && bookings.length === 0" class="text-gray-500 italic">
      No bookings found.
    </p>
    
    <table v-if="bookings.length" class="w-full border-collapse mt-4">
      <thead>
        <tr class="bg-gray-100 border">
          <th class="p-2 border text-left">Date</th>
          <th class="p-2 border text-left">Time</th>
          <th class="p-2 border text-left">Service</th>
          <th class="p-2 border text-left">Customer</th>
          <th class="p-2 border text-left">Email</th>
          <th class="p-2 border text-left">Notes</th>
          <th class="p-2 border text-left">Status</th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="b in bookings"
          :key="b.id"
          class="border hover:bg-gray-50 transition"
        >
          <td class="p-2 border">{{ b.date }}</td>
          <td class="p-2 border">{{ b.time.slice(0,5) }}</td>
          <td class="p-2 border">{{ b.service?.name || '-' }}</td>
          <td class="p-2 border">{{ b.name || '-' }}</td>
          <td class="p-2 border">{{ b.email }}</td>
          <td class="p-2 border">{{ b.notes || '-' }}</td>
          <td class="p-2 border capitalize">{{ b.status }}</td>
        </tr>
      </tbody>
    </table>

  </div>
</template>

<script>
import api from "../services/api";

export default {
  data() {
    return {
      bookings: [],
      loading: true
    };
  },

  async created() {
    const res = await api.get("/admin/bookings");
    this.bookings = res.data.data;
    this.loading = false;
  }
};
</script>
