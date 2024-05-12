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
 
                </div>
                <div class="row mb-3"></div>
                <div class="form-group row">
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
                  <div class="col-sm-6">
                      <label for="commission" class="form-label">% of Commission*
                          <p>the percentage to be deducted from the total rent collected. Click <strong @click="showFixed">here</strong> to add fixed amount</p>
                      </label>
                      <div class="col-sm-10">
                          <input v-if="!showFixedCommission" type="text" placeholder="Write in decimal e.g 0.05" v-model="form.commission" id="commission" name="commission" class="form-control" required />
                          <input v-else type="text" placeholder="Fixed commission amount" v-model="form.fixed_commission" id="fixedCommission" name="fixedCommission" class="form-control" required />
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
         showFixedCommission: false,
         landlords: [],
         submitting: false,
         submitted: false
      }   
   },
   methods: {
      addLandlord(){
        this.$router.push('/add-pmslandlord')
      },
       showFixed() {
          this.showFixedCommission = true;
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
   }
}
</script>
