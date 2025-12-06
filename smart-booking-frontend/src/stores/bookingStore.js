import { defineStore } from "pinia";
import api from "../services/api";

export const useBookingStore = defineStore("bookingStore", {
  state: () => ({
    date: new Date().toISOString().slice(0, 10),
    slots: [],
    slotsLoaded: false,
    selectedSlot: null,
    successMessage: "",
    errors: {},
    formMessage: "",
  }),

  actions: {
    async fetchSlots(serviceId) {
      if (!this.date || !serviceId) return;

      this.slotsLoaded = false;
      this.selectedSlot = null;

      const res = await api.get("/availability", {
        params: {
          date: this.date,
          service_id: serviceId,
        },
      });

      this.slots = res.data.slots || [];
      this.slotsLoaded = true;
    },

    setDate(date) {
      this.date = date;
      this.selectedSlot = null;
      this.successMessage = "";
    },

    selectSlot(slot) {
        this.resetSuccess();
        this.selectedSlot = slot;
    },

    resetSuccess() {
        this.successMessage = "";
        this.formMessage = "";
    },

    bookingSuccess(message) {
      this.successMessage = message;
      this.selectedSlot = null;
    },

    async bookAppointment(payload) {
        this.errors = {};
        this.formMessage = "";
        console.log('book appointment payload', payload)
        try {
            const res = await api.post("/bookings", payload);
            this.formMessage = res.data.message;
            this.successMessage = res.data.message;
            return true;

        } catch (err) {
            if (err.response?.status === 422) {
            this.errors = err.response.data.errors;
            } else {
            this.formMessage = err.response?.data?.message || "Booking failed.";
            }
            return false;
        }
        }
  }
});
