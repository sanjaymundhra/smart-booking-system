<template>
  <div>
    <VueDatePicker
      v-model="internalValue"
      :type="'date'"
      :min-date="new Date()"
      :enable-time-picker="false"
      auto-apply
      input-format="yyyy-MM-dd"
      model-type="yyyy-MM-dd"
      @update:model-value="emitValue"
      class="w-full"
    />

  </div>
</template>

<script>
import { VueDatePicker } from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

export default {
  name: "Calendar",
  components: { VueDatePicker },

  props: {
    modelValue: {
      type: String,
      default: null
    }
  },

  data() {
    return {
      internalValue: this.modelValue
    };
  },

  methods: {
    emitValue(value) {
      this.$emit("update:modelValue", value);
    },
  },

  watch: {
    modelValue(newValue) {
      this.internalValue = newValue;
    }
  }
};
</script>

<style scoped>
/* Optional custom styling */
</style>
