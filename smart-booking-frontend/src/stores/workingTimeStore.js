import { defineStore } from "pinia";
import api from "../services/api";

export const useWorkingTimeStore = defineStore("workingTimeStore", {
  state: () => ({
    workingTimes: [],
    errors: {},
  }),

  actions: {
    async loadWorkingTimes() {
      const res = await api.get("/working-times");
      this.workingTimes = res.data.data;
    },

    async addWorkingTime(form) {
      try {
        this.errors = {};
        await api.post("/working-times", form);
        await this.loadWorkingTimes();
      } catch (err) {
        if (err.response?.status === 422) {
          this.errors = err.response.data.errors;
        } else {
          this.errors.general = err.response?.data?.message || "Error adding rule";
        }
      }
    },

    async deleteWorkingTime(id) {
      await api.delete(`/working-times/${id}`);
      await this.loadWorkingTimes();
    }
  }
});
