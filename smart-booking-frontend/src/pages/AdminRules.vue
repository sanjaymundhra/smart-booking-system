<template>
  <div class="p-4 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Add Working Time</h1>

    <form @submit.prevent="submitForm" class="mb-6">

      <label class="font-semibold">Service:</label>
      <select v-model="form.service_id" class="border p-2 w-full mb-2 rounded bg-white">
        <option :value="null">-- All Services --</option>
        <option v-for="s in serviceStore.services" :key="s.id" :value="s.id">
          {{ s.name }}
        </option>
      </select>
      <p v-if="workingStore.errors.service_id" class="text-red-600 text-sm">
        {{ workingStore.errors.service_id[0] }}
      </p>

      <label class="font-semibold">Day of the Week:</label>
      <select v-model="form.day_of_week" class="border p-2 w-full mb-2 rounded bg-white">
        <option :value="null">-- Select Weekday --</option>
        <option v-for="(name, index) in weekdays" :key="index" :value="index">
          {{ name }}
        </option>
      </select>

      <!-- Date -->
      <label>Date (optional):</label>
      <input type="date" v-model="form.date" class="border p-2 w-full mb-2" />

      <!-- Time -->
      <label>Start Time:</label>
      <input type="time" v-model="form.start_time" class="border p-2 w-full mb-2" />

      <label>End Time:</label>
      <input type="time" v-model="form.end_time" class="border p-2 w-full mb-2" />

      <!-- Interval -->
      <label class="font-semibold">Interval (minutes):</label>
      <select v-model="form.slot_interval_minutes" class="border p-2 w-full mb-4 rounded bg-white">
        <option :value="15">15 minutes</option>
        <option :value="30">30 minutes</option>
        <option :value="45">45 minutes</option>
        <option :value="60">60 minutes</option>
      </select>

      <!-- Notes -->
      <label>Description:</label>
      <input type="text" v-model="form.notes" class="border p-2 w-full mb-4" />

      <!-- Errors -->
      <p v-if="workingStore.errors.general" class="text-red-600 text-sm mb-2">
        {{ workingStore.errors.general }}
      </p>

      <button class="bg-blue-500 text-white px-4 py-2 rounded">Add Working Time</button>
    </form>
  </div>
</template>

<script>
import { useWorkingTimeStore } from "../stores/workingTimeStore";
import { useServiceStore } from "../stores/serviceStore";

export default {
  setup() {
    const workingStore = useWorkingTimeStore();
    const serviceStore = useServiceStore();

    workingStore.loadWorkingTimes();
    serviceStore.loadServices();

    const form = {
      service_id: null,
      day_of_week: null,
      date: null,
      start_time: "09:00",
      end_time: "17:00",
      slot_interval_minutes: 30,
      notes: ""
    };

    const weekdays = [
      "Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"
    ];

    const submitForm = () => {
      workingStore.addWorkingTime(form);
    };

    return { workingStore, serviceStore, form, weekdays, submitForm };
  }
};
</script>
