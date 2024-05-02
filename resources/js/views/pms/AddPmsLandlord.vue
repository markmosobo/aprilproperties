<template>
    <TheMaster>
        <div class="card px-2">
       <div class="card-body">
          <!-- General Form Elements -->
          <form @submit.prevent="">
          <fieldset v-if="step == 1">
             <h5 class="card-title text-center">Add Landlord</h5>
 
             <div class="row m-auto p-auto justify-content- g-3 needs-validation" novalidate="" autocomplete="off">
                <div class="row  mb-3"></div>
 
                <div class="row mb-3"></div>
                <div class="form-group row">
                   <input
                      type="hidden"
                      id="user_id"
                      name="user_id"
                      value="1"
                      class="form-control"
                   />
                    <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">First Name*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="First Name"
                            id="first_name"
                            name="first_name"
                            v-model="form.first_name"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback" v-if="!form.first_name">Please enter first name!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Last Name*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="Last Name"
                            id="last_name"
                            name="last_name"
                            v-model="form.last_name"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback" v-if="!form.last_name">Please enter last name!</div>
                      </div>
                   </div>
 
                </div>
                <div class="row mb-3"></div>
                <div class="form-group row">
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Email Address</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="Email Address"
                            id="title"
                            name="title"
                            v-model="form.email"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Phone Number</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="Phone Number"
                            id="title"
                            name="title"
                            v-model="form.phone_no"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>

                </div>

                <div class="row mb-3"></div>
                <div class="form-group row">
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Physical Address</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="Physical Address"
                            id="title"
                            name="title"
                            v-model="form.address"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">National ID Number</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="National ID Number"
                            id="title"
                            name="title"
                            v-model="form.id_number"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>

                </div>

             </div>
             <!--  button -->
             <div class="col-lg-12 felx mt-4 row">
                <div class="col-sm-6 col-lg-6">
                    <!-- <button @click.prevent="prev()" class="btn btn-dark">Previous</button> -->
                </div>
                <div class="col-sm-6 col-lg-6 text-end">
                    <!-- <button type="submit" style="background-color: darkgreen; border-color: darkgreen;" @click.prevent="submit()" class="btn btn-sm btn-primary rounded-pill">Submit</button> -->
                    <button type="submit" 
                          style="background-color: darkgreen; border-color: darkgreen;" 
                          @click.prevent="submit()" 
                          :class="{ 'btn-success': !submitting, 'btn-secondary': submitting }"
                          class="btn rounded-pill"
                          :disabled="submitting">
                      <span v-if="!submitted">Submit</span>
                      <span v-else>Submitting...</span>
                  </button>
                </div>
            </div>
          </fieldset>
 
          </form>
 
 
          <!-- End General Form Elements -->
       </div>
    </div>
    </TheMaster>
    
 
 
    <!--  actual form -->
 </template>
    
 <script>
 import TheMaster from "@/components/dashboard/TheMaster.vue";

 import axios from "axios";
 import Swal from 'sweetalert2';

 
 const toast = Swal.mixin({
     toast: true,
     position: 'top-end',
     showConfirmButton: false,
     timer: 3000
 });
 
 window.toast = toast;
 
 export default {
    components : {
       TheMaster,
    },
    data () {
       return {
          form: {
          role_id: '',
          title: '',
          
          },
          message: "",
          successMessage: "",
          loading: false,
          step: 1, 
          roles: [],
          submitting: false,
          submitted: false
       }   
    },
    methods: {
       //ID upload
       onChangePhoto(e) {
         console.log('loadings');
         let file = e.target.files[0];
         console.log(file)
         let reader = new FileReader();
         reader.onloadend = (file) => {
            // console.log('RESULT', reader.result)
            this.form.image = reader.result;
         }
         reader.readAsDataURL(file);
       },
       async submit() {
            if (this.validateForm()) {

                // Start submitting process
                this.submitting = true;
                
                try {
                    // Simulate asynchronous submission process (you would replace this with your actual submission logic)
                    await this.submitForm();

                    // Submission successful
                    this.submitted = true;
                } catch (error) {
                    // Handle submission error
                    console.error("Submission error:", error);
                } finally {
                    // End submitting process
                    this.submitting = false;
                }
            }
        },
        validateForm() {
          let isValid = true;
          if (!this.form.first_name) {
              isValid = false;
              document.getElementById('first_name').classList.add('is-invalid');
          } else {
              document.getElementById('first_name').classList.remove('is-invalid');
          }
          if (!this.form.last_name) {
              isValid = false;
              document.getElementById('last_name').classList.add('is-invalid');
          } else {
              document.getElementById('last_name').classList.remove('is-invalid');
          }
          return isValid;
       },        
       async submitForm(){
          axios.post("api/landlords", this.form)
          .then(function (response) {
             console.log(response);
             // this.step = 1;
             toast.fire(
                'Success!',
                'Landlord added!',
                'success'
             )
          })
          .catch(function (error) {
             console.log(error);
             // Swal.fire(
             //    'error!',
             //    // phone_error + id_error + pass_number,
             //    'error'
             // )
          });
          this.$router.push('/pmslandlords')
       }
 
    },
    mounted() {
    }
 
 }
 </script>
    
 
 
