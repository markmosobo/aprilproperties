<template>
  <TheMaster>
    <div class="card px-2">
       <div class="card-body">
          <!-- General Form Elements -->
          <form @submit.prevent="submitForm" novalidate>
             <h5 class="card-title text-center">Edit Property</h5>
 
             <div class="row m-auto p-auto justify-content- g-3" autocomplete="off">
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
                       <label for="title" class="form-label">Name*</label>
                       <div class="col-sm-10">
                          <input type="text" placeholder="Name" id="title" v-model="form.name" name="title" class="form-control"
                             required />
                          <div class="invalid-feedback" v-if="!form.name">Please enter name</div>
                       </div>
                    </div>
                   <div class="col-sm-6">
                      <label for="landlord" class="form-label">Landlord*<p>in case landlord is not listed, click <strong @click="addLandlord">here</strong> to add</p></label>
                      <div class="col-sm-10">
                         <select name="landlord" v-model="form.landlord_id" class="form-select" id="landlord" required>
                            <option value="0" disabled>Select Landlord</option>
                            <option v-for="landlord in landlords" :value="landlord.id"
                            :selected="landlord.id == form.landlord_id" :key="landlord.id">{{ landlord.first_name}} {{ landlord.last_name}}</option>
 
                         </select>
 
                      <div class="invalid-feedback" v-if="!form.landlord_id">Please select a landlord</div>
                      </div>
                   </div>                      
 
                </div>
                <div class="row mb-3"></div>
                <div class="form-group row">
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
                   <div class="row mb-3"></div>
               
             </div>
             <!--  button -->
             <div class="col-lg-12 felx mt-4 row">
                <div class="col-sm-6 col-lg-6">
                    <!-- <button @click.prevent="prev()" class="btn btn-dark">Previous</button> -->
                </div>
                <div class="col-sm-6 col-lg-6 text-end">
                    <button type="submit" 
                          style="background-color: darkgreen; border-color: darkgreen;" 
                          :class="{ 'btn-success': !submitting, 'btn-secondary': submitting }"
                          class="btn rounded-pill"
                          :disabled="submitting">
                      <span v-if="!submitted">Submit</span>
                      <span v-else>Submitting...</span>
                  </button>

                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addLandlordModal" tabindex="-1" aria-labelledby="adLandlordModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="adLandlordModalLabel">Add Landlord</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>
                        <div class="row">
                            <div class="col-sm-6">
                              <strong>First Name:</strong>
                              <input type="text" name="first_name" v-model="landlord.first_name" class="form-control">
                              <div v-if="errors.first_name" class="text-danger">{{ errors.first_name }}</div>
                            </div>
                            <div class="col-sm-6">
                              <strong>Last Name:</strong>
                              <input type="text" name="last_name" v-model="landlord.last_name" class="form-control">
                              <div v-if="errors.last_name" class="text-danger">{{ errors.last_name }}</div>
                            </div>
                        </div>      
                    </p>
                    
                    <p>
                      <strong>Email Address:</strong>
                      <input type="text" name="email" v-model="landlord.email" class="form-control">
                      <div v-if="errors.email" class="text-danger">{{ errors.email }}</div>
                    </p>

                    <p>
                      <strong>Phone Number:</strong>
                      <input type="text" name="phone_no" v-model="landlord.phone_no" class="form-control">
                      <div v-if="errors.phone_no" class="text-danger">{{ errors.phone_no }}</div>
                    </p>

                    <p>
                      <strong>Physical Address:</strong>
                      <input type="text" name="address" v-model="landlord.address" class="form-control">
                      <div v-if="errors.address" class="text-danger">{{ errors.address }}</div>
                    </p>

                    <p>
                      <strong>ID Number:</strong>
                      <input type="text" name="id_number" v-model="landlord.id_number" class="form-control">
                      <div v-if="errors.id_number" class="text-danger">{{ errors.id_number }}</div>
                    </p>


                    <p>
                        <div class="row">
                            <div class="col-sm-6">
                              <strong>Commission:  <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="This is the commission percentage e.g 8"></i>
                              </strong>
                              <input type="number" name="first_name" v-model="landlord.commission"
                              :disabled="disableCommission" class="form-control">
                            </div>
                            <div class="col-sm-6">
                              <strong>Fixed Commission:<i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="This is the agreed commission amount e.g 12000"></i>
                              </strong>
                              <input type="number" name="last_name" v-model="landlord.fixed_commission"
                               :disabled="disableFixedCommission" class="form-control">
                            </div>
                        </div>      
                    </p>
                    


                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-primary" @click.prevent="submitLandlord">Submit</button>
                  </div>
                </div>
              </div>
            </div>
 
          </form>
 
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
  components:{
     TheMaster
  },
   data () {
      return {
         form: {  
         commission: '',
         fixed_commission: '',       
         created_by: '',
         media: [],
         property_status: '',
         
         },
         errors:{
            first_name: '',
            last_name: '',
            email: '',
            phone_no: '',
            address: '',
            id_number: '',
            commission: '',
            fixed_commission: ''
         },
         landlord:{
            first_name: '',
             last_name: '',
             email: '',
             phone_no: '',
             address: '',
             id_number: '',
             commission: '',
             fixed_commission: '',
         },         
         landlords: [],
         submitting: false,
         submitted: false
      }   
   },
   methods: {
      submitLandlord() {
          // Validate
          if (!this.landlord.first_name) {
            this.errors.first_name = 'First name is required.';
            return;
          }
          if (!this.landlord.last_name) {
            this.errors.last_name = 'Last name is required.';
            return;
          }

          axios.post("/api/landlords", this.landlord)
            .then((response) => {
              console.log(response);
              // this.step = 1;
              toast.fire(
                'Success!',
                'Landlord added!',
                'success'
              );
              // Close the modal after saving landlord
              const modal = bootstrap.Modal.getInstance(document.getElementById('addLandlordModal'));
              modal.hide();
              // Reset landlord
              this.landlord.first_name = '';
              this.landlord.last_name = '';
              this.landlord.email = '';
              this.landlord.phone_no = '';
              this.landlord.address = '';
              this.landlord.id_number = '';
              this.landlord.commission = '';
              this.landlord.fixed_commission = '';
              // Reset errors
              this.errors.first_name = '';
              this.errors.last_name = '';
              this.errors.email = '';
              this.errors.phone_no = '';
              this.errors.address = '';
              this.errors.id_number = '';
              this.errors.commission = '';
              this.errors.fixed_commission = '';
              this.loadLists(); // Ensure this is called correctly
            })
            .catch((error) => {
              console.log(error);
              // Swal.fire(
              //    'error!',
              //    // phone_error + id_error + pass_number,
              //    'error'
              // )
            });
        },

      async submitForm() {
            if (this.validateForm()) {
                this.submitting = true;
                try {
                    const response = await axios.put("/api/pmsproperty/"+this.$route.params.id, this.form);
                    console.log(response);
                    let propdata = response.data.property;
                    this.propertyId = response.data.property.id;
                    console.log("property", this.propertyId);

                    console.log("data", propdata.id);

                    toast.fire(
                        'Success!',
                        'Property updated!',
                        'success'
                    );

                    this.$router.push('/managedproperties');
                } catch (error) {
                    console.error("Submission error:", error);
                } finally {
                    this.submitting = false;
                }
            }
        },
      validateForm() {
          let isValid = true;
          if (!this.form.name) {
              isValid = false;
              document.getElementById('title').classList.add('is-invalid');
          } else {
              document.getElementById('title').classList.remove('is-invalid');
          }
          if (!this.form.landlord_id) {
              isValid = false;
              document.getElementById('landlord').classList.add('is-invalid');
          } else {
              document.getElementById('landlord').classList.remove('is-invalid');
          }
          return isValid;
      },
      addLandlord()
      {
        this.landlord.first_name = ''; // Reset the form field
        this.errors.first_name = ''; // Reset the error message

        this.landlord.last_name = ''; // Reset the form field
        this.errors.last_name = ''; // Reset the error message

        this.landlord.phone_no = ''; // Reset the form field
        this.errors.phone_no = ''; // Reset the error message

        // Show the modal after fetching data
        const modal = new bootstrap.Modal(document.getElementById('addLandlordModal'));
        modal.show();
      },

      getProperty() {
             axios.get('/api/pmsproperty/'+this.$route.params.id).then((response) => {
     
             this.form = response.data.property;
             console.log("props", this.form)
    
             });
        },
      loadLists() {
            axios.get('/api/lists').then((response) => {
            this.landlords = response.data.lists.landlords;
   
            });
       },       
   },
   mounted() {
      this.loadLists();
      this.getProperty()
      this.user = localStorage.getItem('user');
      this.user = JSON.parse(this.user);
      this.form.created_by = this.user.id;
      this.form.phone_number = this.user.phone
      console.log("user",this.user)
   },
   computed: {
        disableFixedCommission() {
            return this.landlord.commission !== '';
        },
        disableCommission() {
            return this.landlord.fixed_commission !== '';
        }
    },
}
</script>
