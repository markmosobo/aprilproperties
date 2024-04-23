<template>
    <main>
      <div class="container">
        <section
          class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4"
        >
          <div class="container">
            <div class="row justify-content-center">
              <div
                class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center"
              >
                <div class="d-flex justify-content-center py-4">
                  <router-link to="/">
                  <a
                    href="#"
                    class="logo d-flex align-items-center w-auto"
                  >
                    <!-- <img src="@/assets/img/logo.png" alt="" /> -->
                    <img src="/images/apex-logo.png" alt="">
                    <span class="d-none d-lg-block" style="color: darkgreen;">APRIL PROPERTIES</span>
                  </a>
                  </router-link>
                </div>
                <!-- End Logo -->
  
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="pt-4 pb-2">
                      <h5 class="card-title text-center pb-0 fs-4" style="color: darkgreen;">
                        Create an Account
                      </h5>
                      <p class="text-center small">
                        Enter your personal details to create account
                      </p>
                    </div>
  
                    <form v-on:submit.prevent="create_user" class="row g-3 needs-validation" novalidate>
                      <div class="col-12">
                        <label for="yourfirstName" class="form-label">First Name</label>
                        <input
                          type="text"
                          name="name"
                          class="form-control"
                          id="yourfirstName"
                          v-model="form.first_name"
                          required
                        />
                        <div class="invalid-feedback">
                          Please, enter your first name!
                        </div>
                      </div>

                      <div class="col-12">
                        <label for="yourName" class="form-label">Last Name</label>
                        <input
                          type="text"
                          name="name"
                          class="form-control"
                          id="yourName"
                          v-model="form.last_name"
                          required
                        />
                        <div class="invalid-feedback">
                          Please, enter your last name!
                        </div>
                      </div>
  
                      <div class="col-12">
                        <label for="yourEmail" class="form-label"
                          >Your Email</label
                        >
                        <input
                          type="email"
                          name="email"
                          class="form-control"
                          id="yourEmail"
                          v-model="form.email"
                          required
                        />
                        <div class="invalid-feedback">
                          Please enter a valid Email adddress!
                        </div>
                      </div>
  
                      <div class="col-12">
                        <label for="yourPassword" class="form-label"
                          >Password</label
                        >
                        <input
                          type="password"
                          name="password"
                          class="form-control"
                          id="yourPassword"
                          v-model="form.password"
                          required
                        />
                        <div class="invalid-feedback">
                          Please enter your password!
                        </div>
                      </div>
  
                      <div class="col-12">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            name="terms"
                            type="checkbox"
                            value=""
                            id="acceptTerms"
                            required
                          />
                          <label class="form-check-label" for="acceptTerms"
                            >I agree and accept the
                            <a href="#" style="color: orange;">terms and conditions</a></label
                          >
                          <div class="invalid-feedback">
                            You must agree before submitting.
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <button class="btn btn-success rounded-pill w-100" type="submit">
                          Create Account
                        </button>
                      </div>
                      <div class="col-12">
                        <p class="small mb-0">
                          Already have an account?
                          <router-link to="login" style="color: orange;">Log In</router-link>
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
                  <!-- Designed by
                  <a href="#">BootstrapMade</a> -->
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>
  </template>
  <script>
  import axios from 'axios'
  import Swal from 'sweetalert2'
  export default {
    data(){
      return {
        form: {
          first_name: '',
          last_name: '',
          email: '',
          password: ''
        }
      }
    },
    methods: {
      create_user(){
            
      axios
      .post('api/register',this.form)
      .then((response) =>{
        console.log(response)
          //reset form after submission
          this.form.first_name = '';
          this.form.last_name = '';
          this.form.email = '';
          this.form.password = '';
          if(response["data"]["status"] == "error")
         {
           Swal.fire({
            title: 'OPPS',
            text:   "error",
            icon: 'warning',
          
        });
         }
         else
         {
           Swal.fire({
            title: 'Hurry',
            text:   "You have been registered successfully",
            icon: 'success',
          
        });
         }
          //success message alert
        //   Swal.fire({
        //   title: 'Hurry',
        //   text:   "User has been registered successfully",
        //   icon: 'success',
          
        // });
      })
      .catch((e)=>{
          console.log(e); 
          Swal.fire({ title: 'Hurry', text:   e, icon: 'warning', });
      })
      }
    }
}
  </script>