<template>

 <div class="flex h-screen bg-gray-100">

    <aside class="w-64 bg-white shadow-lg flex flex-col">
      <h2 class="text-xl font-bold p-4 border-b">Smart Booking Dashboard</h2>

      <nav class="flex-1 p-4 space-y-2">
        
        <button
          @click="page = 'book'"
          :class="navClass('book')"
        >
         Book An Appointment
        </button>

        <button
          @click="page = 'admin'"
          :class="navClass('admin')"
        >
          Add Working Time Rules
        </button>

        <button
          @click="page = 'existing-working-time'"
          :class="navClass('existing-working-time')"
        >
          Existing Working Time
        </button>

        <button
          @click="page = 'bookings'"
          :class="navClass('bookings')"
        >
          Booking List
        </button>

      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-y-auto">

      <BookPage v-if="page === 'book'" />
      <AdminRules v-if="page === 'admin'" />
      <AdminWorkingTimes v-if="page === 'existing-working-time'" />
      <AdminBookings v-if="page === 'bookings'" />

    </main>

  </div>
</template>


<script>
  import BookPage from "./pages/BookPage.vue";
  import AdminRules from "./pages/AdminRules.vue";
  import AdminBookings from "./pages/AdminBookings.vue";
  import AdminWorkingTimes from "./pages/AdminWorkingTimes.vue";

  export default {
    components: { BookPage, AdminRules, AdminBookings, AdminWorkingTimes },
    data() {
      return {
        page: "book"
      };
    },

    methods: {
      navClass(section) {
        return [
          "w-full text-left px-4 py-2 rounded transition",
          this.page === section
            ? "bg-blue-600 text-white shadow"
            : "bg-gray-100 hover:bg-gray-200 text-gray-700"
        ];
      }
    }
  };
</script>

