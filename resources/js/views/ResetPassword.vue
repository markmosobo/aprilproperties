<template>
  <main class="background-image">
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-4">
                <router-link to="/">
                  <a href="#" class="logo d-flex align-items-center w-auto">
                    <img src="@/assets/img/apex-logo.png" alt="" />
                    <span class="d-none d-lg-block" style="color: darkgreen;">APRIL PROPERTIES</span>
                  </a>
                </router-link>
              </div>

              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4" style="color: darkgreen;">
                      Reset Password
                    </h5>
                    <p class="text-center small">
                      Enter your email
                    </p>
                  </div>

                  <form v-on:submit.prevent="resetPassword" class="row g-3 needs-validation" novalidate>
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <input
                        type="text"
                        name="email"
                        class="form-control"
                        id="yourUsername"
                        v-model="form.email"
                        required
                      />
                      <div v-if="errors.email" class="text-danger">{{ errors.email }}</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-success rounded-pill w-100" type="submit">
                        <span v-if="loading">
                          <i class="fa fa-spinner fa-spin"></i> Sending...
                        </span>
                        <span v-else>
                          Send Reset Link
                        </span>
                      </button>
                    </div>

                    <div class="col-12">
                      <p class="small mb-0">
                        Don't have an account?
                        <router-link to="/register" style="color: orange;">Create Account</router-link>
                      </p>
                    </div>
                  </form>
                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                <!-- Designed by <a href="#">BootstrapMade</a> -->
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

export default {
  data() {
    return {
      form: {
        email: '',
      },
      errors: {
        email: '',
      },
      loading: false
    };
  },
  methods: {
    togglePasswordVisibility() {
      this.isPasswordVisible = !this.isPasswordVisible;
    },
    async resetPassword() {
      // Clear previous errors
      this.errors = {};

      // Validate email
      if (!this.form.email) {
        this.errors.email = 'Email is required.';
        return;
      }

      this.loading = true; // Set loading to true

      try {
        // Send password reset request
        const response = await axios.put('api/resetpassword', this.form);

        // Reset form fields
        this.form.email = '';
        this.loading = false; // Set loading to false

        // Show success message and handle further logic
        if (response.data.status === 200) {
          toast.fire({
            title: 'Success',
            text: 'Password reset successful!Check your email.',
            icon: 'success'
          });
          // Redirect or handle further actions
          // Example: this.$router.push('/login');
        } else {
          Swal.fire({
            title: 'Oops',
            text: 'Password reset failed. Please try again later.',
            icon: 'error'
          });
        }
      } catch (error) {
        console.error(error);
        this.loading = false; // Set loading to false
        Swal.fire({
          title: 'Error',
          text: error.response.data.message,
          icon: 'error'
        });
      }
    }
  }
};
</script>

<style scoped>
.background-image {
  background-image: url('@/assets/img/april.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  height: 100vh;
  width: 100%;
}

.container {
  height: 100%;
  align-items: center;
  justify-content: center;
}
</style>
