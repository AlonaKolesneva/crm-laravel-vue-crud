<template>
  <div>
    <form @submit.prevent="emitSubmit">
      <div class="row g-3">
        <div class="col-md-3">
          <label for="clientName" class="form-label">Name:</label>
          <input type="text" class="form-control" id="clientName" v-model="clientData.name"
            placeholder="Enter client name" required>
        </div>
        <div class="col-md-3">
          <label for="clientEmail" class="form-label">Email:</label>
          <input type="email" class="form-control" id="clientEmail" v-model="clientData.email"
            placeholder="Enter client email" required>
        </div>
        <div class="col-md-3">
          <label for="clientPhone" class="form-label">Phone:</label>
          <input type="tel" class="form-control" id="clientPhone" v-model="clientData.phone"
            placeholder="Enter client phone" required>
        </div>
        <div class="col-md-3">
          <label for="clientAddress" class="form-label">Address:</label>
          <input type="text" class="form-control" id="clientAddress" v-model="clientData.address"
            placeholder="Enter client address" required>
        </div>
      </div>
      <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary px-4">{{ submitButtonText }}</button>
      </div>
    </form>
  </div>
</template>

<script>

export default {
  props: {
    client: {
      type: Object,
      required: true
    },
    submitButtonText: {
      type: String,
      default: 'Submit'
    }
  },
  data() {
    return {
      clientData: { ...this.client }
    }
  },
  watch: {
    client: {
      handler(newValue) {
        this.clientData = { ...newValue }
      },
      deep: true
    }
  },
  methods: {
    emitSubmit() {
      this.$emit('submit', this.clientData)
    }
  }
}
</script>