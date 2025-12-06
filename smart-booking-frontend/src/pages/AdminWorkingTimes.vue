<template>
  <div class="p-4 max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-4">Manage Working Time</h1>

    <WorkingTimeList />

  </div>
</template>

<script>
import WorkingTimeList from "../components/working-times/WorkingTimeList.vue";

export default {
  components: { WorkingTimeList }
};
</script>
