<template>
    <TheMaster>
        <div class="card px-2">
       <div class="card-body">
          <!-- General Form Elements -->
          <form @submit.prevent="">
          <fieldset v-if="step == 1">
             <h5 class="card-title text-center">Add unit</h5>
 
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
                      <label for="inputPassword" class="form-label">Unit Number*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="Unit Number"
                            id="unit_number"
                            name="unit_number"
                            v-model="form.unit_number"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback" v-if="!form.unit_number">Please enter unit number!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Type*</label>
                      <div class="col-sm-10">
                         <select name="type" v-model="form.type" class="form-select" id="type">
                            <option value="0" selected disabled>Select Type</option>
                            <option value="Residential">Residential</option>
                            <option value="Commercial">Commercial</option>
 
                         </select>
                        <div class="invalid-feedback" v-if="!form.type">Please select type!</div>
                      </div>
                   </div>
 
                </div>
                <div class="row mb-3"></div>
                <div class="form-group row">
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Rent Deposit*</label>
                      <div class="col-sm-10">
                        <input
                            type="number"
                            placeholder="Deposit"
                            id="deposit"
                            name="deposit"
                            v-model="form.deposit"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback" v-if="!form.deposit">Please enter deposit!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Monthly Rent*</label>
                      <div class="col-sm-10">
                        <input
                            type="number"
                            placeholder="Monthly Rent"
                            id="monthly_rent"
                            name="monthly_rent"
                            v-model="form.monthly_rent"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback" v-if="!form.monthly_rent">Please enter monthly rent!</div>
                      </div>
                   </div>

                </div>
                <div class="row mb-3"></div>
                <div class="form-group row">
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Monthly Garbage Collection Fee</label>
                      <div class="col-sm-10">
                        <input
                            type="number"
                            placeholder="Optional e.g 500"
                            id="title"
                            name="title"
                            v-model="form.garbage_fee"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Monthly Security Fee</label>
                      <div class="col-sm-10">
                        <input
                            type="number"
                            placeholder="Optional e.g 500"
                            id="title"
                            name="title"
                            v-model="form.security_fee"
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
                      <label for="inputPassword" class="form-label">Electricity Deposit</label>
                      <div class="col-sm-10">
                        <input
                            type="number"
                            placeholder="Optional e.g 500"
                            id="title"
                            name="title"
                            v-model="form.electricity_deposit"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Water Deposit</label>
                      <div class="col-sm-10">
                        <input
                            type="number"
                            placeholder="Optional e.g 500"
                            id="title"
                            name="title"
                            v-model="form.water_deposit"
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
                      <label for="inputPassword" class="form-label">Electricity Meter No</label>
                      <div class="col-sm-10">
                        <input
                            type="number"
                            placeholder="Optional"
                            id="title"
                            name="title"
                            v-model="form.electricity_meter"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter title!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Water Meter No</label>
                      <div class="col-sm-10">
                        <input
                            type="number"
                            placeholder="Optional"
                            id="title"
                            name="title"
                            v-model="form.water_meter"
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
                    <!-- <button type="submit" @click.prevent="submit()" class="btn btn-sm btn-primary rounded-pill">Submit</button> -->
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
          unit_number: '',
          type: '',
          deposit: '',
          monthly_rent: '',
          garbage_fee: '0.00',
          security_fee: '0.00',
          electricity_deposit: '0.00',
          water_deposit: '0.00'
          
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
          if (!this.form.unit_number) {
              isValid = false;
              document.getElementById('unit_number').classList.add('is-invalid');
          } else {
              document.getElementById('unit_number').classList.remove('is-invalid');
          }
          if (!this.form.type) {
              isValid = false;
              document.getElementById('type').classList.add('is-invalid');
          } else {
              document.getElementById('type').classList.remove('is-invalid');
          }
          if (!this.form.deposit) {
              isValid = false;
              document.getElementById('deposit').classList.add('is-invalid');
          } else {
              document.getElementById('deposit').classList.remove('is-invalid');
          }
          if (!this.form.monthly_rent) {
              isValid = false;
              document.getElementById('monthly_rent').classList.add('is-invalid');
          } else {
              document.getElementById('monthly_rent').classList.remove('is-invalid');
          }
          return isValid;
       },
       submitForm(){
          axios.post("/api/pmsunits/"+this.$route.params.id, this.form)
          .then(function (response) {
             console.log(response);
             // this.step = 1;
             toast.fire(
                'Success!',
                'Unit added!',
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
          this.$router.push('/pmsunits/'+this.$route.params.id)
       }
 
    },
    mounted() {
    }
 
 }
 </script>
    
 
 
