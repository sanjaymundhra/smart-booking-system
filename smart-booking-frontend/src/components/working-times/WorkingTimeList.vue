<template>
  <div>
    <h2 class="text-xl font-semibold mb-2">Existing Working Times</h2>

    <ul v-if="workingStore.workingTimes.length > 0">
      <li
        v-for="t in workingStore.workingTimes"
        :key="t.id"
        class="p-2 border rounded flex justify-between mb-2"
      >
        <span class="flex flex-col">

            <span class="font-semibold text-blue-700 flex items-center gap-1">
                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">
                {{ t.service?.name || "All Services" }}
                </span>
            </span>

            <span class="text-gray-600 text-sm mt-1">
                <span v-if="t.day_of_week !== null">
                <strong>{{ weekdays[t.day_of_week] }}</strong>
                </span>
                <span v-else>
                <strong>{{ formatDate(t.date) }}</strong>
                </span>
            </span>

            <span class="text-gray-800 mt-1">
                {{ t.start_time }} → {{ t.end_time }}
            </span>

        </span>

        <button
          class="bg-red-500 text-white px-2 rounded"
          @click="workingStore.deleteWorkingTime(t.id)"
        >
          Delete
        </button>
      </li>
    </ul>

    <p v-else class="text-gray-500 italic mt-2">No Working Time added yet.</p>
  </div>
</template>

<script>
import { useWorkingTimeStore } from "../../stores/workingTimeStore";

export default {
  setup() {
    const workingStore = useWorkingTimeStore();
    workingStore.loadWorkingTimes();

    const weekdays = [
        "Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"
    ];
    return { workingStore, weekdays };
  }
};
</script>
