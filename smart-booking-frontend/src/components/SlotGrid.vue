<template>
  <div v-if="slots.length">
    <h2 class="text-xl font-semibold mb-3">Available Slots</h2>

    <div v-for="(group, label) in groupedSlots" :key="label" class="mb-5">
      <h3 class="text-lg font-medium mb-2 text-gray-700">{{ label }}</h3>

      <div class="flex flex-wrap gap-2">
        <button
          v-for="slot in group"
          :key="slot.time"
          @click="$emit('select-slot', slot.time)"
          class="px-4 py-2 rounded-full border transition text-sm"
          :class="[
            !slot.available
            ? 'bg-gray-300 text-gray-500 cursor-not-allowed border-gray-400'
            : selected === slot.time
                ? 'bg-green-600 text-white border-green-700 shadow-md scale-105'
                : 'bg-white hover:bg-green-50 text-gray-700 border-gray-300'
          ]"
        >
          {{ slot.time }}
          <div
            v-if="!slot.available"
            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 px-2 py-1 text-xs
                  bg-black text-white rounded opacity-0 group-hover:opacity-100 transition"
          >
            Booked
          </div>
        </button>
      </div>
    </div>
  </div>

  <div v-else-if="loaded" class="mt-4 text-red-600">
    No available slots for this date.
  </div>
</template>

<script>
export default {
  props: {
    slots: Array,
    selected: String,
    loaded: Boolean
  },

  computed: {
    groupedSlots() {
      let groups = {
        "Morning": [],
        "Afternoon": [],
        "Evening": []
      };

      this.slots.forEach(slot => {
        if (!slot || !slot.time) return;

        const hour = parseInt(slot.time.split(":")[0]);

        if (hour < 12) groups["Morning"].push(slot);
        else if (hour < 17) groups["Afternoon"].push(slot);
        else groups["Evening"].push(slot);
      });

      return Object.fromEntries(
        Object.entries(groups).filter(([label, items]) => items.length > 0)
      );
    }
  }
};
</script>
