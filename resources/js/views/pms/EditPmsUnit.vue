<template>
    <TheMaster>
        <div class="card px-2">
       <div class="card-body">
          <!-- General Form Elements -->
          <form @submit.prevent="">
          <fieldset v-if="step == 1">
             <h5 class="card-title text-center">Edit unit</h5>
 
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
                      <label for="inputPassword" class="form-label">Deposit*</label>
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
                            placeholder="Electricity Meter No"
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
                            placeholder="Water Meter No"
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
                <div class="row mb-3"></div>
                <div v-if="propertyId == 5" class="form-group row">
                   <div class="col-sm-6">
                       <label for="title" class="form-label">Paybill Number*</label>
                       <div class="col-sm-10">
                          <input type="text" placeholder="Paybill Number" id="title" v-model="form.paybill_number" name="title" class="form-control"
                             required />
                          <div class="invalid-feedback" v-if="!form.name">Please enter name</div>
                       </div>
                    </div>              
                   <div class="col-sm-6">
                       <label for="title" class="form-label">Account Number*</label>
                       <div class="col-sm-10">
                          <input type="text" placeholder="Account Number" id="title" v-model="form.account_number" name="title" class="form-control"
                             required />
                          <div class="invalid-feedback" v-if="!form.name">Please enter name</div>
                       </div>
                    </div>
               
                   </div>
             </div>
             <!--  button -->
             <div class="col-lg-12 felx mt-4 row">
                <div class="col-sm-6 col-lg-6">
                    <button @click.prevent="back()" class="btn btn-sm btn-dark rounded-pill">Back</button>
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
          unit_number: '',
          type: '',
          deposit: '',
          monthly_rent: '',
          garbage_fee: 0,
          security_fee: '',
          electricity_deposit: '',
          water_deposit: '',
          
          },
          propertyId: '',
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
        getUnit() {
             axios.get('/api/pmsunit/'+this.$route.params.id).then((response) => {
     
             this.form = response.data.unit;
             this.propertyId = this.form.pms_property_id;
             console.log("props", this.propertyId)
    
             });
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
          axios.put("/api/pmsunit/"+this.$route.params.id, this.form)
          .then(function (response) {
             console.log(response);
             // this.step = 1;
             toast.fire(
                'Success!',
                'Unit updated!',
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
          this.$router.push('/pmsunits/'+this.form.pms_property_id)
       },
       back(){
         this.$router.go(-1);
       }
 
    },
    mounted() {
      this.getUnit()
    }
 
 }
 </script>
    
 
 
