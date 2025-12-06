import { defineStore } from "pinia";
import api from "../services/api";

export const useServiceStore = defineStore("serviceStore", {
  state: () => ({
    services: [],
    selectedServiceId: null,
  }),

  actions: {
    async loadServices() {
      const res = await api.get("/services");
      this.services = res.data.data;

      if (!this.selectedServiceId && this.services.length) {
        this.selectedServiceId = this.services[0].id;
      }
    },

    setService(id) {
      this.selectedServiceId = id;
    }
  }
});
